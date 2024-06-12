@extends('layouts.layouts')

@section('title','kutikomiAll')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kutikomiAll.css')}}">
@endsection

@section('content')
    <div class="container">
        @if($kutikomis->isEmpty())
        <div class="kutikomi-null">
            <p>現在口コミはありません</p>
        </div>
        @endif
        @foreach($kutikomis as $kutikomi)
            <div class="kutikomi-main">
                @Auth
                @if($kutikomi->user_id == Auth::user()->id || Auth::user()->role == 100)
                <div class="kutikomi-menu">
                    @if($kutikomi->user_id == Auth::user()->id)
                    <div>
                        <form action="{{route('kutikomiIndex',['id' => $shop->id])}}">
                            <button class="kutikomi-button">口コミを編集</button>
                        </form>
                    </div>
                    @endif
                    <div>
                        <form action="{{route('kutikomiDelete')}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" value="{{$kutikomi->id}}" name="id">
                            <input type="hidden" value="{{$kutikomi->shop_id}}" name="shop_id">
                            <button class="kutikomi-button">口コミを削除</button>
                        </form>
                    </div>
                </div>
                @endif
                @endAuth
                <p>
                    <span class="star5_kutikomi" data-rate="{{$kutikomi->score}}" id="star5_rating_kutikomi"></span>
                </p>
                <div class="flex__item kutikomi-area">
                    <div class="kutikomi-photo">
                        <img src="{{asset($kutikomi->path)}}" alt="">
                    </div>
                    <div class="kutikomi-p">
                        <p>{{$kutikomi->kutikomi}}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="back">
            <form action="{{route('detail',['id' => $shop->id])}}" method="get" name="id">
                <button class="detail">店舗ページへ戻る</button>
            </form>
        </div>
@endsection