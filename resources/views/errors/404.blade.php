@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="wrap">
            <p class="notfound__code" aria-hidden="true">404</p>
            <h1 class="notfound__title">Такой страницы нет</h1>
            <p class="notfound__path">Запрошенный путь: <code>/{{ request()->path() }}</code></p>
            <a class="back" href="{{ route('catalog.index') }}">Вернуться к расписанию</a>
        </div>
    </section>
@endsection
