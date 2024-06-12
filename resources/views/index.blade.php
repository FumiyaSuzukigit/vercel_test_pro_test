@extends('layouts.layouts')

@section('title','index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="search">
        <div class="sorting-area default">
            <form action="{{route('sorting')}}" method="get">
            <select value="sorting" name="sorting" onchange="this.form.submit()">
                <option value="">並べ替え：評価高/低</option>
                <option value="random">ランダム</option>
                <option value="avg_high">評価が高い順</option>
                <option value="avg_low">評価が低い順</option>
            </select>
            @auth
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            </form>
        </div>
        <div class="search-area default">
            <form action="{{route('search')}}" method="get">
            <select value="all area" id="area" name="area" <!--onchange="this.form.submit()"-->>
                <option value="">all area</option>
                @foreach($areas as $area)
                <option value="{{$area->area}}">{{$area->area}}</option>
                @endforeach
            </select>
            <select value="all genre" id="category"  name="category" <!--onchange="this.form.submit()"-->>
                <option value="">all genre</option>
                @foreach($categories as $category)
                <option value="{{$category->category}}">{{$category->category}}</option>
                @endforeach
            </select>
            <input type="search" placeholder="Search" id="search"  name="name">
            @auth
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            <button type="submit">search</button>
            </form>
        </div>
        <div class="responsive-search responsive">
            <div class="sorting-area responsive-search-sorting responsive">
                <form action="{{route('sorting')}}" method="get">
                <select value="sorting" name="sorting" onchange="this.form.submit()">
                    <option value="">並べ替え：評価高/低</option>
                    <option value="random">ランダム</option>
                    <option value="avg_high">評価が高い順</option>
                    <option value="avg_low">評価が低い順</option>
                </select>
                @auth
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                @endauth
                </form>
            </div>
            <div class="search-area responsive">
                <form action="{{route('search')}}" method="get">
                <p>
                    <select value="all area" id="area" name="area" <!--onchange="this.form.submit()"-->>
                    <option value="">all area</option>
                    @foreach($areas as $area)
                    <option value="{{$area->area}}">{{$area->area}}</option>
                    @endforeach
                    </select>
                </p>
                <p>
                    <select value="all genre" id="category"  name="category" <!--onchange="this.form.submit()"-->>
                    <option value="">all genre</option>
                    @foreach($categories as $category)
                    <option value="{{$category->category}}">{{$category->category}}</option>
                    @endforeach
                    </select>
                </p>
                <p><input type="search" placeholder="Search" id="search"  name="name"></p>
                @auth
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                @endauth
                <p><button type="submit">search</button></p>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="flex__item shop-wrap">
            @foreach($shops as $shop)
            <div class="shop-wrap__item">
                <img src="{{asset($shop->path)}}" class="shop-wrap__item-eyecatch">
                <div class="shop-wrap__item-content">
                    <div class="flex__item name-score">
                        <h2>{{$shop->name}}</h2>
                        <p class="result-rating-rate">
                        <span class="star5_rating" data-rate="{{ round($shop->kutikomis_avg_score, 1) }}"></span>
                        <span class="number_rating">{{ round($shop->kutikomis_avg_score, 1) }}</span>
                    </p>
                    </div>
                    <div>
                        <p class="shop-wrap__item-content-tag">#{{$shop->area}}</p>
                        <p class="shop-wrap__item-content-tag">#{{$shop->category}}</p>
                    </div>
                    <div class="shop-wrap__item-bottom">
                        <form action="{{route('detail',['id' => $shop->id])}}" method="get" name="id">
                            <button class="detail">詳しく見る</button>
                        </form>
                        @auth
                                @php
                                $favorite=0;
                                if(!empty(App\Models\Favorite::where('user_id',Auth::user()->id)->where('shop_id',$shop->id)->first())){
                                    $favorite++;
                                }
                                @endphp
                                @if($favorite==1)
                                <form class="favoriteDelete deleteOrigin{{$shop->id}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/red.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                @else
                                <form class="favoriteStore storeOrigin{{$shop->id}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/glay.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                @endif
                                <form class="favoriteDelete delete{{$shop->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/red.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                <form class="favoriteStore store{{$shop->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/glay.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
        <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.favoriteDelete').on('submit', function(event){
            event.preventDefault();
            const user_id=$(this).find('input[name="user_id"]').val();
            const shop_id=$(this).find('input[name="shop_id"]').val();
            $.ajax({
                url: "{{ route('favoriteDelete') }}",
                method: "delete",
                data: {user_id:user_id,shop_id:shop_id},
                dataType: "json",
            }).done(function(res){
                $('.deleteOrigin'+res.shop_id).addClass('none');
                $('.delete'+res.shop_id).addClass('none');
                $('.store'+res.shop_id).removeClass('none');
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.favoriteStore').on('submit', function(event){
            event.preventDefault();
            const user_id=$(this).find('input[name="user_id"]').val();
            const shop_id=$(this).find('input[name="shop_id"]').val();
            $.ajax({
                url: "{{ route('favoriteStore') }}",
                method: "POST",
                data: {user_id:user_id,shop_id:shop_id},
                dataType: "json",
            }).done(function(res){
                $('.storeOrigin'+res.shop_id).addClass('none');
                $('.store'+res.shop_id).addClass('none');
                $('.delete'+res.shop_id).removeClass('none');
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>
@endsection