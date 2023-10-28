<div>
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rating)
        ★
        @else
        ☆
        @endif
    @endfor
</div>
