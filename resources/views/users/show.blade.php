@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <div class="profile">
        <div class="profile_main">
            <div class="profile_main_left">
                <div>
                    @if($user->image !== '')
                        <img src="{{ asset('storage/' . $user->image) }}">
                    @else
                        <img src="{{ asset('images/no_image_profile.png') }}">
                    @endif
                </div>
                <div>
                    <a href="{{ route('profile.edit_image') }}">
                        画像を変更
                    </a>
                    <a href="{{ route('profile.edit') }}">
                        プロフィール編集
                    </a>
                </div>
            </div>
            <div class="profile_main_right">
                <div>
                    <div class="profile_main_right_name">{{ $user->name }}</div>
                <div>
                    出品数　{{ $user->items->count() }}
                </div>
                <diV>
                    @if($user->profile !== '')
                        {{ $user->profile }}
                    @else
                        プロフィールは設定されていません
                    @endif
                </diV>
            </div>
        </div>
    </div>
    
    <div class="profile_history" >
        <h2>購入履歴</h2>
        <ul class="profile_history_items">
            @forelse($order_items as $item)
                <li class="profile_history_item">
                    <div>
                        <div class="item_index">商品名</div>
                        <a href="{{ route('items.show', $item) }}">
                            {{ $item->name }}
                        </a>
                    </div>
                    <div>
                        <div class="item_index">価格</div>
                        {{ $item->price }}円
                    </div>
                    <div>
                        <div class="item_index">出品者</div>
                        {{ $item->user->name }}
                    </div>
                </li>
            @empty
                <li>購入履歴はありません。</li>
            @endif
        </ul>
    </div>
@endsection