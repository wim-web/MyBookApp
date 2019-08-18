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
        $loginUsersBooks = $this->fetchLoginUsersBooks();

        return $loginUsersBooks;
    }

    public function store(Request $request)
    {
        $bookData = $request->all();
        $bookData['user_id'] = Auth::id();
        $this->book->fill($bookData)->save();

        return response('success', 201);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response('success', 200);
    }

    public function updateStatus(Request $request, Book $book)
    {
        $status = $request->all();
        $book->fill($status)->save();
        $loginUsersBooks = $this->fetchLoginUsersBooks();

        return $loginUsersBooks;
    }

    public function showPublicPage(String $name)
    {
        $user = $this->user->where('name', $name)->first();
        return  $user->books()->paginate(12);
    }

    // method

    public function fetchLoginUsersBooks()
    {
        $loginUser = Auth::user();

        return $loginUser->books()->paginate(12);
    }
}
