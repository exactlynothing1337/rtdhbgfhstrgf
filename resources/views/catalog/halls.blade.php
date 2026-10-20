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
                @foreach ($halls as $hall)
                    <li class="rows__item">
                        <a class="rows__link" href="{{ route('catalog.hall', $hall) }}">{{ $hall }}</a>
                    </li>
                @endforeach
            </ul>
            <a class="back" href="{{ route('catalog.index') }}">Назад к расписанию</a>
        </div>
    </section>
@endsection
