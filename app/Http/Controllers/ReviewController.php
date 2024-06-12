<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function reviewAdd(Request $request){

    if($request->score==null){
        return redirect()->route('detail', [$request->shop_id])->with('message', '星は必ずつけてください');
    }
    $review=$request->only(['score','review']);
    Review::find($request->id)->update($review);
    return redirect()->route('detail', [$request->shop_id]);
    }

    public function reviewDelete(Request $request){

    Review::find($request->id)->update(['score'=>null,'review'=>null]);
    return redirect()->route('detail', [$request->shop_id]);
    }
}
