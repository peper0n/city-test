@extends('layouts.app')

@section('content')
    <h1>О нас для города: {{ ucfirst($city->name) }}</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. {{ ucfirst($city->name) }}</p>

    <a href="{{ route('cities.reset') }}">На главную</a>
    <a href="{{ route('cities.about', $city->slug) }}">О нас</a>
    <a href="{{ route('cities.news', $city->slug) }}">Новости</a>
@endsection
