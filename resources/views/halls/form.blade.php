@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <h1 class="hero__title">{{ $title }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <form method="POST" class="form" novalidate
                  action="{{ $hall->exists ? route('halls.update', $hall) : route('halls.store') }}">
                @csrf
                @if ($hall->exists) @method('PUT') @endif

                <label class="form__label">Название
                    <input name="name" value="{{ old('name', $hall->name) }}" class="field @error('name') is-invalid @enderror">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <label class="form__label">Площадь, м²
                    <input type="number" name="area" value="{{ old('area', $hall->area) }}" class="field @error('area') is-invalid @enderror">
                    @error('area') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <div class="form__actions">
                    <button class="btn">Сохранить</button>
                    <a class="back" href="{{ route('halls.index') }}">Отмена</a>
                </div>
            </form>
        </div>
    </section>
@endsection
