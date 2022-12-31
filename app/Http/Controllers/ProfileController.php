<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\ProfileEditImageRequest;

class ProfileController extends Controller
{
    // プロフィール編集
    public function edit()
    {
        return view('profile.edit',[
            'title' => 'プロフィール編集',
            'user' => \Auth::user(),
        ]);
    }
    
    // プロフィール編集処理
    public function update(ProfileEditRequest $request)
    {
        $profile = '';
        if($request->profile !== null){
            $profile = $request->profile;
        }
        
        $user = \Auth::user();
        $user->update([
            'name' => $request->name,
            'profile' => $profile,
        ]);
        session()->flash('success', 'プロフィールを編集しました');
        return redirect()->route('users.show', $user);
    }
    
    // プロフィール画像編集
    public function editImage()
    {
        return view('profile.edit_image',[
            'title' => 'プロフィール画像編集',
            'user' => \Auth::user(),
        ]);
    }
    
    // プロフィール画像編集処理
    public function updateImage(ProfileEditImageRequest $request)
    {
        // ストレージへ画像を保存
        $path = '';
        $image = $request->file('image');
        
        if(isset($image) === true){
            $path = $image->store('photos', 'public');
        }
        
        // 元画像の削除
        $user = \Auth::user();
        if($user->image !== ''){
            \Storage::disk('public')->delete('storage/' . $user->image );
        }
        
        // DBのパス情報をアップデート
        $user->update([
            'image' => $path,
        ]);
        
        session()->flash('success', 'プロフィール画像を変更しました');
        return redirect()->route('users.show', $user);
    }
    
    // アクセス制限（アクション実行前にログインチェックが行われ、ログイン時でないとアクションを実行できない）
    public function __construct()
    {
        $this->middleware('auth');
    }
}
