@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <ul class="like_items">
        @forelse($items as $item)
            <li>
                @if($item->salse_status === 'release')
                    <div>【出品中】</div>
                @else
                    <diV>【売り切れ】</diV>
                @endif
        
                <div class="like_item">
                    <div>
                        <a href="{{ route('items.show', $item) }}">
                            <img src="{{ asset('storage/' . $item->image) }}">
                        </a>
                        <div>
                            {{ $item->name }} / {{ $item->category->japanese_name }}
                        </div>
                        <div>
                            ￥{{ $item->price }}
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
            <li>商品はありません</li>
        @endforelse
    </ul>
    
@endsection