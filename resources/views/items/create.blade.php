@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>商品を出品</h1>
    <h2>新規出品フォーム</h2>
    
    <form class="create_item" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="item_window_box">
            <label>
                <div class="item_index">商品名:</div>
                <input type="text" name="name">
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">商品説明:</div>
                <textarea class="item_description_window" name="description"></textarea>
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">価格(円):</div>
                <input type="text" name="price">
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">カテゴリー:</div>
                <select name="category_id">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->japanese_name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">画像:</div>
                <input type="file" name="image">
            </label>
        </div>
        <input type="submit" value="出品">
    </form>
@endsection