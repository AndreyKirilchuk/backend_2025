@extends('layout.index')

@section('content')
    <form action="/admin/login" method="post">
        @csrf
        <div class="title">
            Вход в админ панель
        </div>

        <label>
            Почта
            <input type="email" name="email"
                value="{{ old('email') }}"
                class="@error('email') input-error @enderror"
            >
            @error('email') <span class="error">{{$message}}</span> @enderror
        </label>

        <label>
            Пароль
            <input type="password" name="password"
                   value="{{ old('password') }}"
                   class="@error('password') input-error @enderror"
            >
            @error('password') <span class="error">{{$message}}</span> @enderror
        </label>

        @error('error')
            <span class="error">
                {{$message}}
            </span>
        @enderror

        <button>
            Войти
        </button>
    </form>
@endsection
