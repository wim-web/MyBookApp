<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }
    public function store(Request $request)
    {
        $DataOfBook = $request->all();
        $this->book->fill($DataOfBook)->save();
        return 'uuu';
    }
}
