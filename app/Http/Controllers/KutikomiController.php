<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Kutikomi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\KutikomiRequest;

class KutikomiController extends Controller
{
        public function kutikomiIndex($id){
        $shop=Shop::find($id);
        $kutikomi=Kutikomi::where('user_id',Auth::user()->id)->where('shop_id',$id)->first();
        return view('/kutikomi',compact('shop','kutikomi'));
        }

        public function kutikomiAll($id){
        $shop=Shop::find($id);
        $kutikomis=Kutikomi::where('shop_id',$id)->get();
        return view('/kutikomiAll',compact('shop','kutikomis'));
        }

        public function kutikomiCreate(KutikomiRequest $request){
        if(Kutikomi::where('shop_id',$request->shop_id)->where('user_id',Auth::user()->id)->first()){
                return redirect()->route('index');
        }
        if(Auth::user()->role>9){
                return redirect()->route('index');
        }
        $kutikomi=$request->only(['shop_id','score','kutikomi']);
        $kutikomi['user_id']=Auth::user()->id;
        if($request->file('image')!==null){
        $randomFileName = Str::random(20);
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/kutikomi_photo', $randomFileName . '.' . $extension);
        $path='storage/kutikomi_photo/'.$randomFileName . '.' . $extension;
        $kutikomi['path']=$path;}

        Kutikomi::create($kutikomi);
        $shop=shop::find($request->shop_id);

        return redirect()->route('kutikomiIndex', ['id' => $shop->id])
                ->with('kutikomi', $kutikomi)
                ->with('message', '投稿が完了しました');
        }

        public function kutikomiUpdate(KutikomiRequest $request){
        if(Auth::user()->role>9){
                return redirect()->route('index');
        }
        $kutikomi=$request->only(['score','kutikomi']);
        if($request->file('image')!==null){
                $randomFileName = Str::random(20);
                $extension = $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs('public/kutikomi_photo', $randomFileName . '.' . $extension);
                $path='storage/kutikomi_photo/'.$randomFileName . '.' . $extension;
                $kutikomi['path']=$path;
        }

        Kutikomi::findOrFail($request->id)->update($kutikomi);

        $kutikomi=Kutikomi::findOrFail($request->id);
        $shop=shop::find($request->shop_id);

        return redirect()->route('kutikomiIndex', ['id' => $shop->id])
                ->with('kutikomi', $kutikomi)
                ->with('message', '投稿の更新が完了しました');
        }

        public function kutikomiDelete(Request $request){
        if(Auth::user()->role==10){
                return redirect()->route('index');
        }
        $kutikomi=Kutikomi::findOrFail($request->id);
        if($kutikomi->user->id!=Auth::user()->id){
                if(Auth::user()->role!=100){
                        return redirect()->route('index');
                }
        }
        Kutikomi::findOrFail($request->id)->delete();
        $shop_id=$request->shop_id;
        return redirect()->route('kutikomiAll', ['id' => $shop_id]);
        }
        }
