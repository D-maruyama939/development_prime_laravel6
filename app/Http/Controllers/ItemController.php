<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemEditRequest;
use App\Http\Requests\ItemEditImageRequest;
use App\Category;
use App\Item;
use App\Order;
use App\Services\FileUploadService;
use App\Services\AuthorityCheckService;

class ItemController extends Controller
{
    //新規出品フォーム
    public function create()
    {
        return view('items.create',[
            'title' => '新規出品',
            'categories' => Category::all(),
        ]);
    }
    
    // 新規出品作成処理
    public function store(ItemRequest $request, FileUploadService $service)
    {
        // 画像ファイルをストレージに保存
        $path = $service->saveImage($request->file('image'));
        
        // 商品情報を追加
        $item = Item::create([
            'user_id' => \Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'image' => $path,
            'salse_status' => 'release',
        ]);
        
        session()->flash('success','商品を出品しました。');
        return redirect()->route('items.show', $item);
    }
    
    // 商品詳細
    public function show($id)
    {
        $item_ids = Item::all()->pluck('id');
        $result = $item_ids->contains($id);
        if($result !== true){
            $item = '';
        }else{
            $item = Item::find($id);
        }
        
        return view('items.show',[
            'title' => '商品詳細',
            'item' => $item,
        ]);
    }

    // 商品情報編集フォーム
    public function edit(AuthorityCheckService $service, Item $item)
    {
        // itemの所有者以外がアクセスすると警告を表示
        $authority = $service->has_authority($item);
        if($authority !== true){
            return redirect()->route('items.show', $item);
        }
        
        return view('items.edit',[
            'title' => '商品情報編集画面',
            'item' => $item,
            'categories' => Category::all(),
        ]);
    }

    // 商品情報更新処理
    public function update(ItemEditRequest $request, AuthorityCheckService $service, Item $item)
    {
        $authority = $service->has_authority($item);
        if($authority !== true){
            return redirect()->route('items.show', $item);
        }
        
        $item->update($request->only([
            'name',
            'description',
            'category_id',
            'price',
        ]));
        
        session()->flash('success', '商品情報を変更しました');
        return redirect()->route('items.show', $item);
    }
    
    // 商品画像編集フォーム
    public function editItemImage(AuthorityCheckService $service, Item $item)
    {
        $authority = $service->has_authority($item);
        if($authority !== true){
            return redirect()->route('items.show', $item);
        }
        
        return view('items.edit_image',[
            'title' => '商品画像編集画面',
            'item' => $item,
        ]);
    }
    
    // 商品画像更新処理
    public function updateItemImage(ItemEditImageRequest $request, FileUploadService $service, AuthorityCheckService $authority_check_service, Item $item)
    {
        $authority = $authority_check_service->has_authority($item);
        if($authority !== true){
            return redirect()->route('items.show', $item);
        }
        
        // 新規画像をストレージに保存し、パスを取得
        $path = $service->saveImage($request->file('image'));
        
        // 元画像をストレージから削除
        if($item->image !== ''){
            \Storage::disk('public')->delete($item->image);
        }
        
        // DBに対して新画像のパスを更新
        $item->update([
            'image' => $path,
        ]);
        
        session()->flash('success', '画像を変更しました');
        return redirect()->route('items.show', $item);
    }
    
    // 購入確認画面
    public function confirm(Item $item)
    {
        return view('items.confirm',[
            'title' => '購入確認画面',
            'item' => $item,
        ]);
    }
    
    // 購入処理
    public function buy(Item $item)
    {
        $salse_status = $item->salse_status;
        
        if($salse_status === 'release'){
        // 売り切れでなければ
            // ステータスを売り切れに変更
            $item->update([
                'salse_status' => 'sold_out',
            ]);
            // 購入履歴を保存
            Order::create([
                'user_id' => \Auth::user()->id,
                'item_id' => $item->id,
            ]);
            //購入完了画面に遷移
            return redirect()->route('items.finish', $item);
            
        }else{
        // もし商品が売り切れていたら
            // 商品詳細画面にリダイレクトし、「申し訳ありません。ちょっと前に売り切れました。」と表示
            return redirect()->route('items.show', $item);
        }
    }
    
    // 購入完了画面
    public function finish(Item $item)
    {
        return view('items.finish',[
            'title' => '購入確定画面',
            'item' => $item,
        ]);
    }
    
    // 商品削除処理
    public function destroy(Item $item, AuthorityCheckService $service)
    {
        $authority = $service->has_authority($item);
        if($authority !== true){
            return redirect()->route('items.show', $item);
        }
        
        $item->delete();
        session()->flash('success', '商品を削除しました');
        return redirect()->route('users.exhibitions', \Auth::user() );
    }
    
    // アクセス制限（アクション実行前にログインチェックが行われ、ログイン時でないとアクションを実行できない）
    public function __construct()
    {
        $this->middleware('auth');
    }
}
