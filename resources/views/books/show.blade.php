@extends('layouts.app')

@section('meta_title', $book->title)

@section('title', $book->title)

@section('sub-title')
    <div class="text-gray-600">by {{ $book->author }}</div>
    <div class="mt-2 flex items-center gap-3">
        <div class="text-center">
            <div class="text-lg font-semibold">{{ number_format($book->reviews_avg_rating, 2) }}</div>
            <x-star-rating :rating="$book->reviews_avg_rating" />
        </div>
        <div class="text-gray-600">
            ({{ $book->reviews_count ?? 0 }} {{ Str::plural('review', $book->reviews_count ?? 0) }})
        </div>
    </div>
@endsection

@section('content')

    <h2 class="text-xl mb-6 font-semibold">Reviews</h2>

    <div>
        @forelse ($book->reviews as $review)
            <div class="px-3 py-4 border border-gray-200 shadow-md rounded-lg mb-5">
                <div class="flex items-center justify-between mb-4">
                    <x-star-rating :rating="$review->rating" />
                    <div class="text-gray-700">{{ $review->created_at }}</div>
                </div>
                <div>{{ $review->review }}</div>
            </div>
        @empty
            <div>Review not find</div>
        @endforelse
    </div>

@endsection
