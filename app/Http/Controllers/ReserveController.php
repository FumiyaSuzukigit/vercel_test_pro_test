<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\ReserveUpdateRequest;
use App\Models\Reserve;
use \Carbon\Carbon;
use App\Models\Shop;

class ReserveController extends Controller
{
    public function reserveAdd(ReserveRequest $request){

        $reserve=$request->only(['user_id','shop_id','date','time','hc']);
        $reserveId=Reserve::create($reserve);
        $reserveData=Reserve::with('shop')->find($reserveId->id);
        if($request->recommendation==1){
            return view('payment.create',compact('reserveData'));
        }
        return redirect('/thanksReserve');
    }

    public function reserveDelete(Request $request){

        Reserve::find($request->id)->delete();
        return redirect('/myPage');
    }

    public function reserveUpdate(ReserveRequest $request){

        $reserve=$request->only(['date','time','hc']);
        Reserve::find($request->id)->update($reserve);
        session()->flash('message', '予約更新が完了しました');
        return redirect('/myPage');
    }

}
