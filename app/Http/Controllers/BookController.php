<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private $book;
    private $user;

    public function __construct(Book $book)
    {
        $this->book = $book;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    public function index()
    {
        $books = $this->user->fetchBooks();

        return $books;
    }

    public function store(Request $request)
    {
        $bookData = $request->all();
        $bookData['user_id'] = $this->user->id;
        $this->book->fill($bookData)->save();

        return response('success', 201);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response('success', 200);
    }

    public function update(Request $request, Book $book)
    {
        $book->fill($request->all())->save();
        return response('success', 200);
    }
}
