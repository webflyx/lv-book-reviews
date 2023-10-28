<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $title = $request->input('title');
        $filter = $request->input('filter') ?? '';

        $books = Book::when($title, function ($query) use ($title) {
            $query->title($title);
        });

        $books = match($filter){
            'popular_last_month' => $books->popularLastMonths(1),
            'popular_last_6month' => $books->popularLastMonths(6),
            'highest_rating_last_month' => $books->bestRatingMonths(1),
            'highest_rating_last_6month' => $books->bestRatingMonths(6),
            default => $books->latest(),
        };  
        
        //$books = $books->get();
        //$books = cache()->remember('books', 3600, fn() => $books->get());

        $cacheKey = 'books:'.$filter.':'.$title;
        $books = cache()->remember($cacheKey, 3600, fn() => $books->get());

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        
        //$book = $book->load(['reviews' => fn($query) => $query->latest()]);
        $cahceKey = 'book:'.$book->id;
        $book = cache()->remember($cahceKey, 3600, fn() => $book->load(['reviews' => fn($query) => $query->latest()]));

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
