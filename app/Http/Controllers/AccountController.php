<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;

class AccountController extends Controller
{
    public function accountIndex(Request $request){

    $users=User::where('role','>',9)->get();
    $shops=Shop::get();
    return view('/account',compact('users','shops'));

    }

    public function accountSearch(Request $request){

    $accounts=User::NameSearch($request->name)->EmailSearch($request->email)->RoleSearch($request->role)->get();
    $users=User::where('role','>',9)->get();
    $shops=Shop::get();
    return view('/account',compact('accounts','users','shops'));
    }

    public function accountDelete(Request $request){

    User::find($request->id)->delete();
    return redirect('/accountIndex');
    }
}
