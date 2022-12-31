<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Item;

class LikeController extends Controller
{
    // お気に入り一覧
    public function index()
    {
        return view('likes.index',[
            'title' => 'お気に入り一覧',
            //いいねしたitemの中間テーブルのcreated_atを取得し新着順に並び替え
            'items' => \Auth::user()->likeItems()->withPivot('created_at as like_at')->orderBy('like_at', 'desc')->get(),
        ]);
    }
    
    // いいね追加・削除処理
    public function toggleLike(Item $item)
    {
        $user = \Auth::user();
        
        if($item->isLikedBy($user)){
            // いいね取り消し
            $item->likes->where('user_id', $user->id)->first()->delete();
            session()->flash('success', 'いいねを取り消しました');
        }else{
            // いいねを設定
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            session()->flash('success', 'いいねしました');
        }
        return redirect()->route('top');
    }
    
    // アクセス制限（アクション実行前にログインチェックが行われ、ログイン時でないとアクションを実行できない）
    public function __construct()
    {
        $this->middleware('auth');
    }
}
