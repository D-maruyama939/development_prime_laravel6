<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\User;

class UserController extends Controller
{
    // トップページ
     public function toppage()
    {
        $items = Item::where('user_id', '<>', \Auth::user()->id)->latest()->get(); //自分のもの以外の商品を新着順で取得
        return view('users.toppage',[
            'title' => 'トップページ',
            'items' => $items,
        ]);
    }
    
    // プロフィール詳細
    public function show(User $user)
    {
        return view('users.show',[
            'title' => 'プロフィール',
            'user' => $user,
            'order_items' => $user->orderItems,
        ]);
    }
    
    // 出品商品一覧
    public function exhibitions($id)
    {
        $user = \Auth::user();
        return view('users.exhibitions',[
            'title' => '出品商品一覧',
            'items' => $user->items()->latest()->get(),
        ]);
    }
    
    // アクセス制限（アクション実行前にログインチェックが行われ、ログイン時でないとアクションを実行できない）
    public function __construct()
    {
        $this->middleware('auth');
    }
}
