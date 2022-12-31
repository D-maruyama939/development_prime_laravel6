@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <h2>現在の画像</h2>
    
    @if($user->image !== '')
        <img src="{{ asset('storage/'. $user->image) }}">
    @else
        <img src="{{ asset('images/no_image_profile.png') }}">
    @endif
    
    <form 
        method="post"
        action="{{ route('profile.update_image') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('patch')
        <div>
            <label>
                画像を選択:
                <input type="file" name="image">
            </label>
        </div>
        <input type="submit" value="更新">
    </form>
@endsection