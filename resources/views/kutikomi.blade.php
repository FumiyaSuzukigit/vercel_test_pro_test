@extends('layouts.layouts')

@section('title','kutikomi')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kutikomi.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item shop-wrap">
            <div class="shop-wrap__area">
                <h1 class="h1">今回のご利用はいかがでしたか？</h1>
                <div class="shop-wrap__item">
                    <img src="{{asset($shop->path)}}" class="shop-wrap__item-eyecatch">
                    <div class="shop-wrap__item-content">
                        <h2>{{$shop->name}}</h2>
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
            </div>
            @if(!$kutikomi)
            <div class="review-area">
                <div class="review-box">
                    <h3>体験を評価をしてください</h3>
                    @if(session('message'))
                    <div class="message">
                        <div>
                            <p class="message-p" id="session">{{session('message')}}</p>
                        </div>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="error">
                        @foreach ($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                        </div>
                    @endif
                    <form action="{{route('kutikomiCreate')}}" method="post" id="form1" enctype="multipart/form-data">
                        <input type="hidden" value="{{$shop->id}}" name="shop_id">
                        @csrf
                        <div class="rate-form">
                            <input id="star5" type="radio" name="score" value="5">
                            <label for="star5">★</label>
                            <input id="star4" type="radio" name="score" value="4">
                            <label for="star4">★</label>
                            <input id="star3" type="radio" name="score" value="3">
                            <label for="star3">★</label>
                            <input id="star2" type="radio" name="score" value="2">
                            <label for="star2">★</label>
                            <input id="star1" type="radio" name="score" value="1">
                            <label for="star1">★</label>
                        </div>
                        <div>
                            <p>口コミを投稿</p>
                            <textarea name="kutikomi" cols="100" rows="10" class="textarea" onkeyup="ShowLength(value);" placeholder="カジュアルな夜にのお出かけにおすすめのスポット"></textarea>
                            <p id="inputlength">0/400 最高文字数</p>
                        </div>
                        <div>
                            <p>画像の追加</p>
                            <div class="upload-box">
                            <div class="preview-box">
                                    <img class="previewImg" src="" alt="画像プレビュー" hidden/>
                            </div>
                            <div class="box-message">
                                <input type="file" accept="image/*" id="input" name="image" hidden/>
                                <span>クリックして画像を追加、または<br>ドラッグ＆ドロップ</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="review-area">
                <div class="review-box">
                    <h3>体験を評価をしてください</h3>
                    @if(session('message'))
                    <div class="message">
                        <div>
                            <p class="message-p" id="session">{{session('message')}}</p>
                        </div>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="error">
                        @foreach ($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                        </div>
                    @endif
                    <form action="{{route('kutikomiUpdate')}}" method="post" id="form2" enctype="multipart/form-data">
                        <input type="hidden" value="{{$kutikomi->id}}" name="id">
                        <input type="hidden" value="{{$shop->id}}" name="shop_id">
                        @csrf
                        <div class="rate-form">
                            <input id="star5" type="radio" name="score" value="5" {{ $kutikomi->score == 5 ? 'checked' : '' }}>
                            <label for="star5">★</label>
                            <input id="star4" type="radio" name="score" value="4" {{ $kutikomi->score == 4 ? 'checked' : '' }}>
                            <label for="star4">★</label>
                            <input id="star3" type="radio" name="score" value="3" {{ $kutikomi->score == 3 ? 'checked' : '' }}>
                            <label for="star3">★</label>
                            <input id="star2" type="radio" name="score" value="2" {{ $kutikomi->score == 2 ? 'checked' : '' }}>
                            <label for="star2">★</label>
                            <input id="star1" type="radio" name="score" value="1" {{ $kutikomi->score == 1 ? 'checked' : '' }}>
                            <label for="star1">★</label>
                        </div>
                        <div>
                            <p>口コミを投稿</p>
                            <textarea name="kutikomi" cols="100" rows="10" class="textarea" onkeyup="ShowLength(value);" placeholder="カジュアルな夜にのお出かけにおすすめのスポット">{{$kutikomi->kutikomi}}</textarea>
                            <p id="inputlength">0/400 最高文字数</p>
                        </div>
                        <div>
                            <p>画像の追加</p>
                            <div class="upload-box">
                            <div class="preview-box">
                                <img src="{{asset($kutikomi->path)}}" class="previewImg" alt="">
                            </div>
                            <div class="box-message">
                                <input type="file" accept="image/*" id="input" name="image" hidden/>
                                <span>クリックして画像を追加、または<br>ドラッグ＆ドロップ</span>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @if(!$kutikomi)
        <div class="submit">
            <button type="submit" form="form1" class="submit-button">口コミを投稿</button>
        </div>
        @else
        <div class="submit">
            <button type="submit" form="form2" class="submit-button">口コミを更新</button>
        </div>
        @endif
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

        function ShowLength( str ) {
        document.getElementById("inputlength").innerHTML = str.length + "/400 最高文字数";
        }

        const uploadBox = document.querySelector(".upload-box");
        const previewBox = document.querySelector(".preview-box img");
        const fileInput = document.getElementById("input");

        function roadImg(e) {
        const file = e.target.files[0];
        if (!file) return;
        previewBox.removeAttribute("hidden");
        previewBox.src = URL.createObjectURL(file);
        }

        fileInput.addEventListener("change", roadImg, false);
        uploadBox.addEventListener("click", () => fileInput.click());

        function dragover(e){
        e.stopPropagation();
        e.preventDefault();
        this.style.background = "#e1e7f0";
        }

        function dragleave(e){
        e.stopPropagation();
        e.preventDefault();
        this.style.background = "#fff";
        }

        function dropLoad(e) {
        e.stopPropagation();
        e.preventDefault();

        uploadBox.style.background = "#fff";
        let files = e.dataTransfer.files;
        if (files.length > 1)
            return alert("アップロードできるファイルは1つだけです。");
        fileInput.files = files;
        previewBox.removeAttribute("hidden");
        previewBox.src = URL.createObjectURL(fileInput.files[0]);
        }

        uploadBox.addEventListener("drop", dropLoad, false);
        uploadBox.addEventListener("dragover", dragover, false);
        uploadBox.addEventListener("dragleave", dragleave, false);

    </script>


@endsection