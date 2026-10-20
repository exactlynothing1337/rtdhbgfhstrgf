@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <h1 class="hero__title">{{ $title }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <form method="POST" action="{{ route('feedback.send') }}" class="form">
                @csrf
                <label class="form__label">Имя
                    <input type="text" name="name" class="field">
                </label>
                <label class="form__label">Сообщение
                    <textarea name="message" class="field" rows="4"></textarea>
                </label>
                <button class="btn">Отправить</button>
            </form>
        </div>
    </section>
@endsection
