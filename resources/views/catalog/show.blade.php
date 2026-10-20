@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="wrap">
            <a class="back" href="{{ route('catalog.index') }}">Назад к расписанию</a>

            <h1 class="detail__title">{{ $training['title'] }}</h1>

            <dl class="facts">
                <div class="facts__item"><dt>Код</dt><dd>{{ $training['code'] }}</dd></div>
                <div class="facts__item"><dt>Зал</dt><dd>{{ $training['hall'] }}</dd></div>
                <div class="facts__item"><dt>Начало</dt><dd>{{ $training['starts_at'] }}</dd></div>
                <div class="facts__item"><dt>Длительность</dt><dd>{{ $training['duration_min'] }} мин</dd></div>
                <div class="facts__item"><dt>Мест</dt><dd>{{ $training['max_people'] }}</dd></div>
                <div class="facts__item"><dt>Групповая</dt><dd>{{ $training['is_group'] ? 'Да' : 'Нет' }}</dd></div>
            </dl>

            <div class="duration">
                <div class="duration__head">
                    <span>Длительность на шкале до двух часов</span>
                    <span>{{ $training['duration_min'] }} мин</span>
                </div>
                <div class="bar bar--lg" style="--d: {{ $training['duration_min'] }}"><span class="bar__fill"></span></div>
                <div class="ruler" aria-hidden="true"></div>
                <div class="ruler-scale" aria-hidden="true"><span>0</span><span>1 час</span><span>2 часа</span></div>
            </div>
        </div>
    </section>
@endsection
