<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    private function datesRange(Builder $q, $from = null, $to = null)
    {
        if($from && !$to){
            $q->where('created_at','>=', $from);
        } elseif (!$from && $to){
            $q->where('created_at','<=', $to);
        } elseif ($from && $to){
            $q->whereBetween('created_at', [$from, $to]);
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
    }


    public function scopePopularRangeDate(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->datesRange($q, $from, $to),
        ])
        ->orderBy('reviews_count', 'desc');
    }

    public function scopeBestRating(Builder $query): Builder
    {
        return $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating','desc');
    }

    public function scopeBestRatingRangeDate(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->datesRange($q, $from, $to)
        ], 'rating')
        ->orderBy('reviews_avg_rating','desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=' , $minReviews);
    }

    public function scopeMaxReviews(Builder $query, int $maxReviews): Builder
    {
        return $query->having('reviews_count', '<=' , $maxReviews);
    }

    public function scopePopularLastMonths(Builder $query, int $popularLastMonths = 1): Builder
    {
        return $query->popularRangeDate(now()->subMonths($popularLastMonths), now())
        ->bestRatingRangeDate(now()->subMonths($popularLastMonths), now())->minReviews(2);
    }

    public function scopeBestRatingMonths(Builder $query, int $popularLastMonths = 1): Builder
    {
        return $query->bestRatingRangeDate(now()->subMonths($popularLastMonths), now())
        ->popularRangeDate(now()->subMonths($popularLastMonths), now())->minReviews(2);
    }

}
