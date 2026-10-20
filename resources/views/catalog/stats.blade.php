@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <h1 class="hero__title">{{ $title }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <ul class="rows">
                <li class="rows__item"><span class="rows__label">Количество тренировок</span><span class="rows__value">{{ $count }}</span></li>
                <li class="rows__item"><span class="rows__label">Средняя длительность, мин</span><span class="rows__value">{{ number_format($avg, 1, ',', ' ') }}</span></li>
                <li class="rows__item"><span class="rows__label">Минимальная длительность, мин</span><span class="rows__value">{{ $min }}</span></li>
                <li class="rows__item"><span class="rows__label">Максимальная длительность, мин</span><span class="rows__value">{{ $max }}</span></li>
            </ul>
            <a class="back" href="{{ route('catalog.index') }}">Назад к расписанию</a>
        </div>
    </section>
@endsection
