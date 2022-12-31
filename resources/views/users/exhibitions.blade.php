@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <a class="new_exhibit" href="{{ route('items.create') }}">新規出品</a>
    
    <ul class="exhibition_items">
        @forelse($items as $item)
            <li>
                 @if($item->salse_status === 'release')
                    <div>【出品中】</div>
                @else
                    <diV>【売り切れ】</diV>
                @endif
        
                <div class="exhibition_item">
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
                        <div class="link_edit_item">
                            <a href="{{ route('items.edit', $item) }}">
                                [編集]
                            </a>
                            <a href="{{ route('items.edit_image', $item) }}">
                                [画像を変更]
                            </a>
                        </div>
                        <form method="post" action="{{ route('items.destroy', $item) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="削除">
                        </form>
                    </div>
                    <div>
                        {{ $item->description }}
                    </div>
                </div>
            </li>
        @empty
            <li>
                出品している商品はありません
            </li>
        @endforelse
    </ul>
@endsection