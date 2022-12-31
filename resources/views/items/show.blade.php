@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    @if($item !== '')
        @if($item->salse_status === 'sold_out')
            <div class="apology">
                <div>【販売状況のお知らせ】</div>
                <p>申し訳ありません。ちょっと前に売り切れました。</p>
            </div>
        @endif
        
        <div clas="item_show">
            <div class="item_index_box">
                <div class="item_index">商品名</div>
                {{ $item->name }}
            </div>
            <div class="item_index_box">
                <div class="item_index">画像</div>
                <img src="{{ asset('storage/' .$item->image ) }}">
            </div>
            <div class="item_index_box">
                <div class="item_index">カテゴリ</div>
                {{ $item->category->japanese_name }}
            </div>
            <div class="item_index_box">
                <diV class="item_index">価格</diV>
                {{ $item->price }}円
            </div>
            <div class="item_index_box">
                <div class="item_index">説明</div>
                {{ $item->description }}
            </div>
            
            <form method="get" action="{{ route('items.confirm', $item) }}">
                @csrf
                <input type="submit" value="購入する">
            </form>
        </div>
    @else
        その商品はありません。
    @endif
@endsection