@extends('layouts.app')

@section('content')
    <h1>Выбранный город: {{ ucfirst($city->name) }}</h1>

    <a href="{{ route('cities.reset') }}">На главную</a>
    <a href="{{ route('cities.about', $city->slug) }}">О нас</a>
    <a href="{{ route('cities.news', $city->slug) }}">Новости</a>
@endsection
