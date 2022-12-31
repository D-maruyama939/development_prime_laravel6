@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <a class="new_exhibit" href="{{ route('items.create') }}" >新規出品</a>
    
    <ul class="toppage_items">
        @forelse($items as $item)
            <li>
                @if($item->salse_status === 'release')
                    <div>【出品中】</div>
                @else
                    <diV>【売り切れ】</diV>
                @endif
        
                <div class="toppage_item">
                    <div>
                        <a href="{{ route('items.show', $item) }}">
                            <img src="{{ asset('storage/' . $item->image) }}">
                        </a>
                        <div>
                            {{ $item->name }} / {{ $item->category->japanese_name }}
                        </div>
                        <div>
                            ￥{{ $item->price }}
                            <a class="like_button">{{ $item->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                            <form method="post" class="like" action="{{ route('likes.toggle_like', $item) }}">
                                @csrf
                                @method('patch')
                            </form> 
                        </div>
                        <div>
                            ({{ $item->created_at }})
                        </div>
                    </div>
                    <div>
                        {{ $item->description }}
                    </div>
                </div>
            </li>
        @empty
            <li>
                <hr>
                商品はありません
            </li>
        @endforelse
    </ul>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        /* global $ */
        $('.like_button').each(function(){
            $(this).on('click', function(){
                $(this).next().submit();
            });
        });
    </script>
@endsection
