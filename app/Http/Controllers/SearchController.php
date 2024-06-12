<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){

        $shops=Shop::with('kutikomis')->withAvg('kutikomis', 'score')->AreaSearch($request->area)->CategorySearch($request->category)->NameSearch($request->name)->get();
        $areas=Shop::select('area')->distinct()->get();
        $categories=Shop::select('category')->distinct()->get();
        return view('/index',compact('shops','areas','categories'));
        }

    public function sorting(Request $request){

        if($request->sorting=="random"){
        $shops = Shop::with('kutikomis')->withAvg('kutikomis', 'score')->inRandomOrder()->get();
        $areas=Shop::select('area')->distinct()->get();
        $categories=Shop::select('category')->distinct()->get();
        return view('/index',compact('shops','areas','categories'));
        }

        if($request->sorting=="avg_high"){
        $shops = Shop::with('kutikomis')
            ->leftJoin('kutikomis', function($join) {
                $join->on('shops.id', '=', 'kutikomis.shop_id')
                    ->whereNull('kutikomis.deleted_at');
            })
            ->select('shops.*')
            ->selectRaw('AVG(kutikomis.score) as kutikomis_avg_score')
            ->groupBy('shops.id')
            ->orderBy('kutikomis_avg_score', 'DESC')
            ->get();
        $areas=Shop::select('area')->distinct()->get();
        $categories=Shop::select('category')->distinct()->get();
        return view('/index',compact('shops','areas','categories'));
        }

        if($request->sorting=="avg_low"){
            $have_kutikomi = Shop::with('kutikomis')
                ->join('kutikomis', 'shops.id', '=', 'kutikomis.shop_id')
                ->whereNull('kutikomis.deleted_at')
                ->select('shops.*')
                ->selectRaw('AVG(kutikomis.score) as kutikomis_avg_score')
                ->groupBy('shops.id')
                ->orderBy('kutikomis_avg_score', 'ASC')
                ->get();

            $no_have_kutikomi = Shop::with('kutikomis')
                ->leftJoin('kutikomis', 'shops.id', '=', 'kutikomis.shop_id')
                ->where(function($query) {
                    $query->whereNull('kutikomis.shop_id')
                        ->orWhereNotNull('kutikomis.deleted_at');
                })
                ->select('shops.*')
                ->get();

            $shops = $have_kutikomi->concat($no_have_kutikomi)->unique('id');

            $areas=Shop::select('area')->distinct()->get();
            $categories=Shop::select('category')->distinct()->get();
            return view('/index',compact('shops','areas','categories'));
        }


    }

}
