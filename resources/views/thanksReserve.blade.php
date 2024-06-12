@extends('layouts.layouts')

@section('title','thanks')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')

    <div class="container">
        <div  class="thanks">
            <h1>ご予約ありがとうございました</h1>
            <a href="/myPage">マイページ</a>
        </div>
    </div>
@endsection