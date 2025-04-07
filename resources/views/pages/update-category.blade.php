@extends('layout.index')

@section('content')
    <a href="/admin/categories">Обратно</a>

    <form action="/admin/categories/{{$category->id}}" method="post">
        @csrf
        @method('PATCH')

        <label>
            Название
            <input type="text" name="name"
            value="{{ $category->name }}"
            class="@error('name') input-error @enderror"
            >
            <span class="error">@error('name') {{$message}} @enderror</span>
        </label>

        <label>
            Описание
            <textarea type="text" name="description"
                   class="@error('description') input-error @enderror"
            >{{ $category->description }}</textarea>
            <span class="error">@error('description') {{$message}} @enderror</span>
        </label>

        <button>
            Редактировать
        </button>
    </form>
@endsection
