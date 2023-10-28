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

        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonths(1),
            'popular_last_6month' => $books->popularLastMonths(6),
            'highest_rating_last_month' => $books->bestRatingMonths(1),
            'highest_rating_last_6month' => $books->bestRatingMonths(6),
            default => $books->withReviewsCount()->withAvgRating()->latest(),
        };

        //$books = $books->get();
        //$books = cache()->remember('books', 3600, fn() => $books->get());

        $cacheKey = 'books:' . $filter . ':' . $title;
        //cache()->forget($cacheKey);
        $books = cache()->remember(
            $cacheKey,
            3600,
            function () use ($books, $filter, $title) {
                if($filter && !$title){
                    return $books->paginate(10)->appends(['filter' => $filter]);
                } elseif(!$filter && $title) {
                    return $books->paginate(10)->appends(['title' => $title]);
                } elseif($filter && $title) {
                    return $books->paginate(10)->appends(['title' => $title, 'filter' => $filter]);
                } else {
                    return $books->paginate(10);
                }
            }
        );
        
        

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
        // $book = Book::with(['reviews' => fn($query) => $query->latest()])
        // ->withReviewsCount()->withAvgRating()->findOrFail($book->id);

        $cahceKey = 'book:' . $book->id;
        //cache()->forget($cahceKey);
        $book = cache()->remember(
            $cahceKey,
            3600,
            fn () => Book::with(['reviews' => fn ($query) => $query->latest()])
                ->withReviewsCount()->withAvgRating()->findOrFail($book->id)
        );

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
