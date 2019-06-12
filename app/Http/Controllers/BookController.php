<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        return $this->userWithBooks();
    }

    public function store(Request $request)
    {
        $bookData = $request->all();
        $bookData['user_id'] = $this->getLoginUserId();
        $this->book->fill($bookData)->save();

        return response('success', 201);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return $this->userWithBooks();
    }

    public function updateStatus(Request $request, Book $book)
    {
        $status = $request->all();
        $book->fill($status)->save();
        
        return $this->userWithBooks();
    }

    public function getLoginUserId()
    {
        return Auth::id();
    }

    public function userWithBooks()
    {
        $loginUser = $this->user->find($this->getLoginUserId());
        return $loginUser->loadBooks();
    }
}
