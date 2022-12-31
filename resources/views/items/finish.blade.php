@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>【ご購入ありがとうございました】</h1>
    
    <div class="item_finish">
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
        
        <div>
            <a class="item_finish_to_top" href="{{route('top')}}">トップに戻る</a>
        </div>
    </div>
@endsection