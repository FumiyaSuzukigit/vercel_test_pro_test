@extends('layouts.layouts')

@section('title','reserveToday')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reserveToday.css')}}">
@endsection

@section('content')

<main class="main">
    <div>
        <h1>
            当日予約状況
        </h1>
    </div>

    <div class="main__search">
        @foreach($reserves as $reserve)
        <h2>{{$reserve->shop->name}}</h2>
        @break
        @endforeach
        <table class="default">
            <tr>
                <th>日付</th>
                <th>時間</th>
                <th>名前</th>
                <th>人数</th>
                <th>事前予約</th>
                <th>キャンセル</th>
            </tr>
            @foreach($reserves as $reserve)
            <tr class="main__search--table">
                <td>{{$reserve->date}}</td>
                <td>{{$reserve->time}}</td>
                <td>{{$reserve->user->name}}</td>
                <td>{{$reserve->hc}}</td>
                <td>{{$reserve->recommendation}}</td>
                <td>{{$reserve->deleted_at}}</td>
                <td>
                    <form action="{{route('informMail')}}" method="get">
                        <input type="hidden" value="{{$reserve->user->name}}" name="name">
                        <input type="hidden" value="{{$reserve->user->email}}" name="email">
                        <input type="hidden" value="{{$reserve->shop->name}}" name="shop">
                        <input type="hidden" value="{{$reserve->hc}}" name="hc">
                        <input type="hidden" value="{{$reserve->date}}" name="date">
                        <input type="hidden" value="{{$reserve->time}}" name="time">
                        <input type="hidden" value="{{$reserve->recommendation}}" name="recommendation">
                        <button type="submit">お知らせメール</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="responsive">
            @foreach($reserves as $reserve)
            <div class="main__search--table-responsive">
                <p><label>日付</label>&emsp;{{$reserve->date}}</p>
                <p><label>時間</label>&emsp;{{$reserve->time}}</p>
                <p><label>名前</label>&emsp;{{$reserve->user->name}}</p>
                <p><label>人数</label>&emsp;{{$reserve->hc}}</p>
                <p><label>事前予約</label>&emsp;{{$reserve->recommendation}}</p>
                <p><label>キャンセル</label>&emsp;{{$reserve->deleted_at}}</p>
                <p>
                    <form action="{{route('informMail')}}" method="get">
                        <input type="hidden" value="{{$reserve->user->name}}" name="name">
                        <input type="hidden" value="{{$reserve->user->email}}" name="email">
                        <input type="hidden" value="{{$reserve->shop->name}}" name="shop">
                        <input type="hidden" value="{{$reserve->hc}}" name="hc">
                        <input type="hidden" value="{{$reserve->date}}" name="date">
                        <input type="hidden" value="{{$reserve->time}}" name="time">
                        <input type="hidden" value="{{$reserve->recommendation}}" name="recommendation">
                        <button type="submit">お知らせメール</button>
                    </form>
                </p>
            </div>
            @endforeach
        </div>
    </div>

</main>

@endsection