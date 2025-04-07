@extends('layout.index')

@section('content')
    <a href="/admin">Обратно</a>

    @foreach($orders as $item)
        <p>
            Товар {{$item->product->name}}
            Почта {{$item->user->email}}
            Цена {{$item->product->price}}
            Статус {{$item->status}}
        </p>
    @endforeach
@endsection
