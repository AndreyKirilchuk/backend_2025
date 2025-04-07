@extends('layout.index')

@section('content')
    <p><a href="/admin/categories">Категории</a></p>
    <p><a href="/admin/products">Товары</a></p>
    <p><a href="/admin/orders">Заказы</a></p>
    <p>
    <form action="/admin/logout" method="post">
      @csrf
      <button>Выйти</button>
    </form>
    </p>

@endsection
