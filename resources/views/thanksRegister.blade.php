@extends('layouts.layouts')

@section('title','thanks')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')
    <div class="container">
        <div  class="thanks">
            <h1>会員登録ありがとうございます</h1>
            <a href="/myPage">本人認証へ進む</a>
        </div>
    </div>
@endsection