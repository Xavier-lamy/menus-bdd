@extends('layouts.app')

@section('header')
{{--Disable header--}}
@endsection

@section('wrapper')
    <div class="bg--primary size--fullscreen dsp--flex flxdir--col justify--center align--center p--3">
        @section('main')
            <p class="m--0 text--light">You need to be connected to access this website</p>
            <a href="{{ route('login') }}" class="button--lg button--secondary m--1 my--3">I already have an account: Login</a>
            <a href="{{ route('register') }}" class="button--lg button--secondary m--1">I am new here: Create an account</a>
        @show
    </div>
@endsection

@section('footer')
{{--Disable footer--}}
@endsection