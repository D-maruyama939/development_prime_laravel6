@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <h2>商品の追加フォーム</h2>
    
    <form method="POST" action="{{ route('items.update', $item) }}">
        @csrf
        @method('patch')
        <div class="item_window_box">
            <label>
                <div class="item_index">商品名:</div>
                <input type="text" name="name" value="{{ $item->name }}">
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">商品説明:</div>
                <textarea class="item_description_window" name="description">{{ $item->description }}</textarea>
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">価格(円):</div>
                <input type="text" name="price" value="{{ $item->price }}">
            </label>
        </div>
        <div class="item_window_box">
            <label>
                <div class="item_index">カテゴリー:</div>
                <select name="category_id">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($categories as $category)
                        <option 
                            value="{{ $category->id }}"
                            @if($category->id === $item->category_id)
                                selected
                            @endif
                        >
                            {{ $category->japanese_name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
        <input type="submit" value="情報を更新して出品">
    </form>
@endsection