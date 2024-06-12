<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    //同期通信
    //public function favoriteStore(Request $request){

    //    $favorite=$request->only(['user_id','shop_id']);
    //    Favorite::create($favorite);
    //    return redirect('/');
    //}

    //非同期通信
    public function favoriteStore(Request $request){
        $favorite=$request->only(['user_id','shop_id']);
        Favorite::create($favorite);
        $shop_id = request()->get('shop_id');
        return response()->json(['shop_id' => $shop_id]);
    }

    //同期通信
    //public function favoriteDelete(Request $request){

    //    Favorite::where('user_id',$request->user_id)->where('shop_id',$request->shop_id)->delete();//
    //    return redirect('/');
    //}

    //非同期通信
    public function favoriteDelete(Request $request){
        $user_id = request()->get('user_id');
        $shop_id = request()->get('shop_id');
        Favorite::where('user_id',$user_id)->where('shop_id',$shop_id)->delete();
        return response()->json(['shop_id' => $shop_id]);
    }

}
