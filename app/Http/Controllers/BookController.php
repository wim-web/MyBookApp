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
        // $this->middleware('auth');
        $this->book = $book;
        $this->user = $user;
    }


    public function index()
    {
        $me = $this->user->find($this->getUserId());
        $myBooks = $me->load(['books' => function($query) {
            $query->orderBy('id', 'desc');
        }]);
        return $myBooks;
    }

    public function store(Request $request)
    {
        //todo: return
        $bookData = $request->all();
        $this->book->fill(['user_id' => $this->getUserId()]);
        $this->book->fill($bookData)->save();
        return 'uuu';
    }

    public function destroy(Book $book)
    {
        $book->delete();
        
        return $this->user->find($this->getUserId())->load(['books' => function($query) {
            $query->orderBy('id', 'desc');
        }]);
    }

    public function updateStatus(Request $request, Book $book)
    {
        $status = $request->all();
        $book->fill($status)->save();

        return $this->user->find($this->getUserId())->load(['books' => function($query) {
            $query->orderBy('id', 'desc');
        }]);
    }

    public function getUserId()
    {
        return Auth::id();
    }
}
