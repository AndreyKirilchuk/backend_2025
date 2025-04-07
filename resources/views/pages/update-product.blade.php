@extends('layout.index')

@section('content')
    <a href="/admin/products">Обратно</a>

    <form action="/admin/products/{{$product->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <label>
            Название
            <input type="text" name="name"
                   value="{{ $product->name }}"
                   class="@error('name') input-error @enderror"
            >
            <span class="error">@error('name') {{$message}} @enderror</span>
        </label>

        <label>
            Описание
            <textarea type="text" name="description"
                      class="@error('description') input-error @enderror"
            >{{ $product->description }}</textarea>
            <span class="error">@error('description') {{$message}} @enderror</span>
        </label>

        <label>
            Цена
            <input type="number" name="price"
                   class="@error('price') input-error @enderror"
                   value="{{ $product->price }}"/>
            <span class="error">@error('price') {{$message}} @enderror</span>
        </label>

        <label>
            Обложка
            <input type="file" name="preview"
                   class="@error('preview') input-error @enderror"
                   value="{{ $product->preview }}" />
            <span class="error">@error('preview') {{$message}} @enderror</span>
        </label>

        <label>
            Категория
            <select name="category_id"
                    class="@error('category_id') input-error @enderror">
                @foreach($categories as $item)
                    <option value="{{$item->id}}"  @if($item->id === $product->category->id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>
            <span class="error">@error('category_id') {{$message}} @enderror</span>
        </label>

        <button>
            Редактировать
        </button>
    </form>
@endsection
