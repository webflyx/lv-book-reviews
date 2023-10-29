@extends('layouts.app')

@section('meta_title', 'Add Review')

@section('title', 'Add Review to ' . $book->title)

@section('content')
    <form action="{{ route('books.reviews.store', $book) }}" method="POST">
        @csrf
        <div class="mb-2">
            <label for="review">Review</label>
            <textarea name="review" rows="2"></textarea>
            @error('review')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="rating">Rating</label>
            <select name="rating">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            @error('rating')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button class="btn-secondary" type="submit">Add Review</button>
        </div>
    </form>
@endsection