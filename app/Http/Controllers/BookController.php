<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;

class BookController extends Controller
{
    private $book;
    private $user;

    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }


    public function index()
    {
        $me = $this->user->find(1);
        $myBooks = $me->load('books');
        return $myBooks;
    }

    public function store(Request $request)
    {
        //todo: return
        $bookData = $request->all();
        $this->book->fill(['user_id' => 1]);
        $this->book->fill($bookData)->save();
        return 'uuu';
    }

    public function destroy(Book $book)
    {
        $book->delete();
        
        return $this->user->find(1)->load('books');
    }
}
