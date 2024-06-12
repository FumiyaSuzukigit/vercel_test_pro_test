<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Representative;
use App\Models\User;
use App\Models\Shop;


class RepresentativeController extends Controller
{

    public function representativeAdd(Request $request){

        if($request->user_id==null||$request->shop_id==null){
            return redirect('/accountIndex')->with('representativeFalse', '両方の選択は必須です');
        }
        $representative=$request->only(['user_id','shop_id']);
        Representative::create($representative);
        return redirect('/accountIndex')->with('representativeSuccess', '店舗代表者を設定しました');
    }

    public function representativeSearch(Request $request){

        $representatives=Representative::with('user','shop')->UserSearch($request->user_id)->ShopSearch($request->shop_id)->get();
        $users=User::where('role','>',9)->get();
        $shops=Shop::get();
        return view('/account',compact('representatives','users','shops'));
    }

    public function representativeDelete(Request $request){

        Representative::find($request->id)->delete();
        return redirect('/accountIndex');
    }
}
