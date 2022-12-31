@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div>
            <label>
                <div>名前:</div>
                <input type="text" name="name" value="{{ $user->name }}">
            </label>
        </div>
        <div>
            <label>
                <div>プロフィール:</div>
                <textarea class="edit_profile_window" name="profile">{{ $user->profile }}</textarea>
            </label>
        </div>
        <input type="submit" value="更新">
    </form>
@endsection