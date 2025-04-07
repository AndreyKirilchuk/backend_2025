@extends('layout.index')

@section('content')
    <a href="/admin">Обратно</a>

    <form action="/admin/categories" method="post">
        @csrf

        <label>
            Название
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="@error('name') input-error @enderror"
            >
            <span class="error">@error('name') {{$message}} @enderror</span>
        </label>

        <label>
            Описание
            <textarea type="text" name="description"
                      class="@error('description') input-error @enderror"
            >{{ old('description') }}</textarea>
            <span class="error">@error('description') {{$message}} @enderror</span>
        </label>

        <button>
            Добавить
        </button>
    </form>

    @foreach($categories as $item)
        <p>
            {{$item->name}}
            Описание {{$item->description}}

            @if($item->products()->count() === 0)
                <form action="/admin/categories/{{$item->id}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button>
                        Удалить
                    </button>
                </form>
            @endif

            <a href="/admin/categories/{{$item->id}}/update">
                <button>
                    Редактировать
                </button>
            </a>

            <a href="/admin/categories/{{$item->id}}/products">
                <button>
                    Товары
                </button>
            </a>
        </p>
    @endforeach

    {{$categories->links()}}
@endsection
