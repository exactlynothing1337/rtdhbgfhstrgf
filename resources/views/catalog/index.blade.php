@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <h1 class="hero__title">{{ $title }}</h1>
            <p class="hero__meta">Найдено тренировок: {{ $trainings->count() }}</p>

            <form method="GET" action="{{ route('catalog.index') }}" class="toolbar">
                <label class="sr-only" for="q">Название</label>
                <input id="q" type="text" name="q" value="{{ $search }}" class="field toolbar__search" placeholder="Название тренировки">

                <label class="sr-only" for="sort">Сортировка</label>
                <select id="sort" name="sort" class="field">
                    <option value="title" @selected($sort === 'title')>По названию</option>
                    <option value="starts_at" @selected($sort === 'starts_at')>По дате начала</option>
                    <option value="duration_min" @selected($sort === 'duration_min')>По длительности</option>
                </select>

                <button class="btn">Найти</button>
            </form>
        </div>
    </section>

    <div class="wrap">
        <ol class="lanes">
            @forelse ($trainings as $t)
                @php($start = \Illuminate\Support\Carbon::parse($t['starts_at'])->locale('ru'))
                <li class="lane">
                    <span class="lane__num">{{ $loop->iteration }}</span>

                    <div class="lane__time">
                        <strong>{{ $start->format('H:i') }}</strong>
                        <span>{{ $start->translatedFormat('D, j F') }}</span>
                    </div>

                    <div class="lane__title">
                        <a class="lane__name" href="{{ route('catalog.show', ['id' => $t['id']]) }}">{{ $t['title'] }}</a>
                        <a class="lane__hall" href="{{ route('catalog.hall', $t['hall']) }}">{{ $t['hall'] }}</a>
                    </div>

                    <div class="lane__bar">
                        <div class="bar" style="--d: {{ $t['duration_min'] }}"><span class="bar__fill"></span></div>
                        <span class="bar__label">{{ $t['duration_min'] }} мин</span>
                    </div>

                    <div class="lane__tag">
                        @if ($t['is_group']) <span class="tag tag--group">Групповая</span> @endif
                    </div>
                </li>
            @empty
                <li class="lanes__empty">
                    Ничего не найдено. <a href="{{ route('catalog.index') }}">Показать все тренировки</a>
                </li>
            @endforelse
        </ol>
    </div>
@endsection
