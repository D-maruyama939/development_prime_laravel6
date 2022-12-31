<?php

namespace App\Services;


class AuthorityCheckService{
    
    public function has_authority($item){
        // 出品者以外がアクセスしたら、警告を表示
        if($item->user_id !== \Auth::user()->id){
            session()->flash('warning', '不正なアクセスです');
            return false;
        }else{
            return true;
        }
    }
}

