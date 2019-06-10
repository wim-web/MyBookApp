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
        $bookData = $request->all();
        $this->book->fill(['user_id' => 1]);
        $this->book->fill($bookData)->save();
        return 'uuu';
    }
}
