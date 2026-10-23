@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <h1 class="hero__title">{{ $title }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <form method="POST" class="form form--wide" novalidate
                  action="{{ $training->exists ? route('trainings.update', $training) : route('trainings.store') }}">
                @csrf
                @if ($training->exists) @method('PUT') @endif

                <label class="form__label">Зал
                    <select name="hall_id" class="field @error('hall_id') is-invalid @enderror">
                        @foreach ($halls as $hall)
                            <option value="{{ $hall->id }}" @selected(old('hall_id', $training->hall_id) == $hall->id)>{{ $hall->name }}</option>
                        @endforeach
                    </select>
                    @error('hall_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <label class="form__label">Название
                    <input name="title" value="{{ old('title', $training->title) }}" class="field @error('title') is-invalid @enderror">
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <label class="form__label">Описание
                    <textarea name="description" rows="3" class="field @error('description') is-invalid @enderror">{{ old('description', $training->description) }}</textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <label class="form__label">Начало
                    <input type="datetime-local" name="starts_at"
                           value="{{ old('starts_at', $training->starts_at?->format('Y-m-d\TH:i')) }}"
                           class="field @error('starts_at') is-invalid @enderror">
                    @error('starts_at') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </label>

                <div class="form__pair">
                    <label class="form__label">Длительность, мин
                        <input type="number" name="duration_min" value="{{ old('duration_min', $training->duration_min) }}"
                               class="field @error('duration_min') is-invalid @enderror">
                        @error('duration_min') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </label>

                    <label class="form__label">Мест
                        <input type="number" name="max_people" value="{{ old('max_people', $training->max_people) }}"
                               class="field @error('max_people') is-invalid @enderror">
                        @error('max_people') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </label>
                </div>

                <label class="check">
                    <input type="checkbox" name="is_group" value="1" @checked(old('is_group', $training->is_group))>
                    Групповая тренировка
                </label>

                {{-- ⭐ 3: M:N — флажки участников, sync() при сохранении --}}
                <fieldset class="fieldset">
                    <legend>Записанные участники</legend>
                    <div class="fieldset__grid">
                        @foreach ($members as $member)
                            <label class="check">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                       @checked(in_array($member->id, old('member_ids', $selected)))>
                                {{ $member->full_name }}
                            </label>
                        @endforeach
                    </div>
                    @error('member_ids') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    @error('member_ids.*') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </fieldset>

                <div class="form__actions">
                    <button class="btn">Сохранить</button>
                    <a class="back" href="{{ route('trainings.index') }}">Отмена</a>
                </div>
            </form>
        </div>
    </section>
@endsection
