@extends('layouts.layouts')

@section('title','account')

@section('css')
<link rel="stylesheet" href="{{ asset('css/account.css')}}">
@endsection

@section('content')

<main class="main">
    <div>
        <h1>
            アカウント管理
        </h1>
    </div>
    <div class="main__search">
        <h2>アカウント検索</h2>
        <form action="{{route('accountSearch')}}" method="get" class="default">
            <div class="main__search--step">
                    <div class="main__search--step-title">
                        お名前
                    </div>
                    <div  class="main__search--step-input">
                        <input type="text" name="name">
                    </div>
                    <div class="main__search--step-title">
                        メールアドレス
                    </div>
                    <div class="main__search--step-input">
                        <input type="email" name="email">
                    </div>
                    <div class="main__search--step-title">
                        権限
                    </div>
                    <div class="main__search--step-input">
                        <select value="権限を選択してください" name="role">
                            <option value="">全権限</option>
                            <option value="100">管理者</option>
                            <option value="10">店舗代表者</option>
                            <option value="1">一般ユーザ</option>
                        </select>
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
        <form action="{{route('accountSearch')}}" method="get" class="responsive">
            <div class="main__search--step-responsive">
                    <div class="main__search--step-title-responsive">
                        お名前
                    </div>
                    <div  class="main__search--step-input-responsive">
                        <input type="text" name="name">
                    </div>
                    <div class="main__search--step-title-responsive">
                        メールアドレス
                    </div>
                    <div class="main__search--step-input-responsive">
                        <input type="email" name="email">
                    </div>
                    <div class="main__search--step-title-responsive">
                        権限
                    </div>
                    <div class="main__search--step-input-responsive">
                        <select value="権限を選択してください" name="role">
                            <option value="">全権限</option>
                            <option value="100">管理者</option>
                            <option value="10">店舗代表者</option>
                            <option value="1">一般ユーザ</option>
                        </select>
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
    </div>

    @isset($accounts)
    <div class="main__add--table">
        <h2>アカウント一覧</h2>
        <div>
            <table>
                <tr>
                    <th>お名前</th>
                    <th>メールアドレス</th>
                    <th>権限</th>
                </tr>
                @foreach($accounts as $account)
                <tr>
                    <form  method="POST" action="{{route('accountDelete')}}">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td>{{$account->name}}</td>
                        <td>{{$account->email}}</td>
                        <td>
                            @if($account->role==100)
                            管理者
                            @elseif($account->role==10)
                            店舗代表者
                            @elseif($account->role==1)
                            一般ユーザ
                            @endif
                        </td>
                        <td><button type="submit">削除</button></td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endisset


    <div class="main__add--table">
        <h2>アカウント設定</h2>
        @if (count($errors) > 0)
            <ul class="error">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            </ul>
        @endif
        @if(session('message'))
            <div class="message">
                <div class="message__success">
                    <p class="message__success--p" id="session">{{session('message')}}</p>
                </div>
            </div>
        @endif
        <table class="default">
            <tr>
                <th>お名前</th>
                <th>メールアドレス</th>
                <th>パスワード</th>
                <th>パスワード再入力</th>
                <th>権限</th>
            </tr>
            <tr>
                <form  method="POST" action="{{ route('register') }}">
                    @csrf
                    <td><input type="text" name="name"  required autofocus autocomplete="name"></td>
                    <td><input type="email" name="email" required autocomplete="username" ></td>
                    <td><input type="password" name="password" required autocomplete="new-password" ></td>
                    <td><input type="password" name="password_confirmation" required autocomplete="new-password"></td>
                    <td>
                        <select name="role">
                        <option value="100">管理者</option>
                        <option value="10">店舗代表者</option>
                        <option value="1">一般ユーザ</option>
                        </select>
                    </td>
                    <td><button type="submit">登録</button></td>
                </form>
            </tr>
        </table>
        <div class="responsive">
            <form  method="POST" action="{{ route('register') }}">
                    @csrf
                    <p>お名前</p>
                    <p><input type="text" name="name"  required autofocus autocomplete="name"></p>
                    <p>メールアドレス</p>
                    <p><input type="email" name="email" required autocomplete="username" ></p>
                    <p>パスワード</p>
                    <p><input type="password" name="password" required autocomplete="new-password" ></p>
                    <p>パスワード再入力</p>
                    <p><input type="password" name="password_confirmation" required autocomplete="new-password"></p>
                    <p>権限</p>
                    <p>
                            <select name="role">
                            <option value="100">管理者</option>
                            <option value="10">店舗代表者</option>
                            <option value="1">一般ユーザ</option>
                            </select>
                    </p>
                    <p><button type="submit">登録</button></p>
            </form>
        </div>
    </div>

    <div class="main__search">
        <h2>店舗代表者検索</h2>
        <form action="{{route('representativeSearch')}}" method="get" class="default">
            <div class="main__search--step">
                    <div class="main__search--step-title">
                        お名前
                    </div>
                    <div  class="main__search--step-input">
                        <select name="user_id">
                            <option value="">選択してください</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="main__search--step-title">
                        店舗名
                    </div>
                    <div class="main__search--step-input">
                        <select name="shop_id">
                            <option value="">選択してください</option>
                            @foreach($shops as $shop)
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
        <form action="{{route('representativeSearch')}}" method="get" class="responsive">
            <div class="main__search--step-responsive">
                    <div class="main__search--step-title-responsive">
                        お名前
                    </div>
                    <div  class="main__search--step-input-responsive">
                        <select name="user_id">
                            <option value="">選択してください</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="main__search--step-title-responsive">
                        店舗名
                    </div>
                    <div class="main__search--step-input-responsive">
                        <select name="shop_id">
                            <option value="">選択してください</option>
                            @foreach($shops as $shop)
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
    </div>

    @isset($representatives)
    <div class="main__add--table">
        <h2>店舗代表者一覧</h2>
        <table>
            <tr class="main__add--table-title">
                <th>お名前</th>
                <th>店舗名</th>
            </tr>
            @foreach($representatives as $representative)
            <tr>
                <form  method="POST" action="{{route('representativeDelete')}}">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="id" value="{{$representative->id}}">
                    <td>{{$representative->user->name}}</td>
                    <td>{{$representative->shop->name}}</td>
                    <td><button type="submit">削除</button></td>
                </form>
            </tr>
            @endforeach
        </table>
    </div>
    @endisset

    <div class="main__add--table">
        <h2>店舗代表者設定</h2>
        @if(session('representativeFalse'))
            <div class="message">
                <p class="representativeMessageFalse" id="session">{{session('representativeFalse')}}</p>
            </div>
        @endif
        @if(session('representativeSuccess'))
            <div class="message">
                <p class="representativeMessageSuccess" id="session">{{session('representativeSuccess')}}</p>
            </div>
        @endif
        <div>
        <table  class="default">
            <tr>
                <th>お名前</th>
                <th>店舗</th>
            </tr>
            <tr>
                <form  method="POST" action="{{route('representativeAdd')}}">
                    @csrf
                    <td>
                        <select name="user_id">
                            <option value="">選択してください</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="shop_id">
                            <option value="">選択してください</option>
                            @foreach($shops as $shop)
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><button type="submit">登録</button></td>
                </form>
            </tr>
        </table>
        <div class="responsive">
            <form  method="POST" action="{{route('representativeAdd')}}">
                @csrf
                <p>お名前</p>
                <p>
                    <select name="user_id">
                            <option value="">選択してください</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                    </select>
                </p>
                <p>店舗</p>
                <p>
                    <select name="shop_id">
                            <option value="">選択してください</option>
                            @foreach($shops as $shop)
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                    </select>
                </p>
                <p><button type="submit">登録</button></p>
            </form>
        </div>
    </div>
</main>

@endsection