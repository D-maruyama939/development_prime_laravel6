@extends('layouts.not_logged_in')

@section('content')
    <h1>ログイン</h1>
    
    <form method="POST" class="login" action="{{ route('login') }}">
        @csrf
        <div class="login_window_box">
            <label>
                <div>メールアドレス:</div>
                <input type="email" name="email">
            </label>
        </div>
        <div class="login_window_box">
            <label>
                <div>パスワード:</div>
                <input type="password" name="password" >
            </label>
        </div>
 
        <input type="submit" value="ログイン">
    </form>
@endsection