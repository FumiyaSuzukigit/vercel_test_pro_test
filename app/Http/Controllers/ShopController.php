<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Kutikomi;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
    $shops = Shop::with('kutikomis')->withAvg('kutikomis', 'score')->get();
    $areas=Shop::select('area')->distinct()->get();
    $categories=Shop::select('category')->distinct()->get();
    return view('/index',compact('shops','areas','categories'));
    }

    public function detail($id){
    $shop=Shop::find($id);
    $reviews=Review::with('user')->where('shop_id',$id)->whereNot('score')->get();
    $reviewCount=$reviews->count();
    $averageScore=round($reviews->avg('score'), 1);
    if(!empty(Auth::user()->id)){
        $reviewArea=Review::where('user_id',Auth::user()->id)->where('shop_id',$id)->first();
        if(!empty($reviewArea->score)){
            $kutikomi=Kutikomi::where('shop_id',$id)->where('user_id',Auth::user()->id)->first();
            return view('/detail',compact('shop','reviews','averageScore','reviewCount','kutikomi'));
        }
        elseif(empty($reviewArea->score)){
            $kutikomi=Kutikomi::where('shop_id',$id)->where('user_id',Auth::user()->id)->first();
            return view('/detail',compact('shop','reviewArea','reviews','averageScore','reviewCount','kutikomi'));
        }
    }
    return view('/detail',compact('shop','reviews','averageScore','reviewCount'));
    }
}
