@extends('layouts.app')

@section('meta_title', 'Books')

@section('title', 'Books')

@section('content')

    <form action="{{ route('books.index') }}" method="GET" class="mb-6 flex gap-4 items-center">
        <input class="w-full" type="text" name="title" value="{{ request('title') }}">
        <button class="btn-secondary" type="submit">Search</button>
        <a class="btn-secondary" href="{{ route('books.index') }}">Clear</a>
    </form>

    @forelse ($books as $book)
        <div class="flex items-center justify-between px-3 py-4 border border-gray-200 shadow-md rounded-lg mb-5">
            <div>
                <a href="{{ route('books.show', $book) }}" class="text-xl font-semibold mb-2 block">{{ $book->title }}</a>
                <div class="text-gray-600">by {{ $book->author }}</div>
            </div>
            <div>
                <div>{{ number_format($book->reviews_avg_rating, 1) }}</div>
                <div>out of {{ $book->reviews_count ?? '0' }} {{ Str::plural('review', $book->reviews_count) }}</div>
            </div>
        </div>
    @empty
        <div class="text-center border border-gray-200 rounded-lg p-4">
            <div class="text-lg font-semibold">Books not found</div>
            <a href="{{ route('books.index') }}" class="block mt-3 underline">Reset filters</a>
        </div>
    @endforelse

@endsection
