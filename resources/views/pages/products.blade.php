@extends('layout.index')

@section('content')
    <a href="/admin">Обратно</a>

    <form action="/admin/products" method="post" enctype="multipart/form-data">
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

        <label>
            Цена
            <input type="number" name="price"
                      class="@error('price') input-error @enderror"
            value="{{ old('price') }}"/>
            <span class="error">@error('price') {{$message}} @enderror</span>
        </label>

        <label>
            Обложка
            <input type="file" name="preview"
                      class="@error('preview') input-error @enderror"
            value="{{ old('preview') }}" />
            <span class="error">@error('preview') {{$message}} @enderror</span>
        </label>

        <label>
            Категория
            <select name="category_id"
                    class="@error('category_id') input-error @enderror">
                <option disabled selected>Выберите категорию</option>
                @foreach($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <span class="error">@error('category_id') {{$message}} @enderror</span>
        </label>

        <button>
            Добавить
        </button>
    </form>

    @foreach($products as $item)
        <p>
            {{$item->name}}
            Описание {{$item->description}}
            Цена {{$item->price}}
            Категория {{$item->category->name}}
            <img src="{{url($item->preview)}}" alt="preview" width="300px">

        <form action="/admin/products/{{$item->id}}" method="post">
            @csrf
            @method('DELETE')
            <button>
                Удалить
            </button>
        </form>

        <a href="/admin/products/{{$item->id}}/update">
            <button>
                Редактировать
            </button>
        </a>
        </p>
    @endforeach
@endsection
