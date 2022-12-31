@extends('layouts.not_logged_in')

@section('title','ユーザー登録')
 
@section('content')
    <h1>ユーザー登録</h1>
 
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="register_window">
            <label>
                <div>ユーザー名:</div>
                <input type="text" name="name">
            </label>
        </div>
 
        <div class="register_window_box">
            <label>
                <div>メールアドレス:</div>
                <input type="email" name="email">
            </label>
        </div>
 
        <div class="register_window_box">
            <label>
                <div>パスワード:</div>
                <input type="password" name="password">
            </label>
        </div>
 
        <div class="register_window">
            <label>
                <div>パスワード（確認用）:</div>
                <input type="password" name="password_confirmation" >
            </label>
        </div>
 
        <div>
            <input type="submit" value="登録">
        </div>
    </form>
@endsection