const chokidar = require('chokidar');
const colors = require('colors');
const fs = require('fs');
const { execSync } = require('child_process');

const logEvent = (event, path) => console.log(`[${event}]`.magenta, path.underline);

const execPhpUnit = (path) => {
    path = path.toString();
    if (! fs.existsSync(path)) {
        console.error(`File not exists: ${path.toString()}`.red);
        return;
    }

    try {
        console.log(execSync(`vendor/bin/phpunit ${path}`).toString().green);
    } catch (err) {
        if (err.stdout) console.error(err.stdout.toString().red);
        if (err.stderr) console.error(err.stderr.toString().red);
    }
};

const settings = [
    { target: 'tests/**/*Test.php',
        resolver: (path) => path },
    { target: 'app/Models/**/*.php',
        resolver: (path) => path.replace(/^app\/(.+)\.php$/, 'tests/Unit/$1Test.php') },
    { target: 'app/Http/Controllers/**/*.php',
        resolver: (path) => path.replace(/^app\/Http\/(.+)\.php$/, 'tests/Feature/$1Test.php') },
];

settings.forEach(({ target, resolver }) => {
    chokidar.watch(target)
        .on('all', (event, path) => {
            if (event != 'change') return;
            logEvent(event, path);
            execPhpUnit(resolver(path.toString()));
        });
});
