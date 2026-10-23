@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <div class="hero__row">
                <h1 class="hero__title">{{ $title }}</h1>
                <a href="{{ route('trainings.create') }}" class="btn">+ Добавить</a>
            </div>
            <p class="hero__meta">Всего найдено: {{ $trainings->total() }}</p>

            <form method="GET" action="{{ route('trainings.index') }}" class="toolbar">
                <label class="sr-only" for="q">Название</label>
                <input id="q" type="text" name="q" value="{{ request('q') }}" class="field toolbar__search" placeholder="Название тренировки">

                <label class="sr-only" for="hall_id">Зал</label>
                <select id="hall_id" name="hall_id" class="field">
                    <option value="">Все залы</option>
                    @foreach ($halls as $hall)
                        <option value="{{ $hall->id }}" @selected(request('hall_id') == $hall->id)>{{ $hall->name }}</option>
                    @endforeach
                </select>

                <label class="sr-only" for="group">Тип</label>
                <select id="group" name="group" class="field">
                    <option value="">Любые</option>
                    <option value="1" @selected(request('group') === '1')>Групповые</option>
                    <option value="0" @selected(request('group') === '0')>Индивидуальные</option>
                </select>

                <button class="btn">Найти</button>
            </form>
        </div>
    </section>

    <div class="wrap section">
        <div class="table-scroll">
            <table class="data">
                <thead>
                    <tr>
                        <th>#</th><th>Название</th><th>Зал</th><th>Начало</th>
                        <th>Длит., мин</th><th>Записано</th><th>Тип</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trainings as $training)
                        <tr>
                            <td class="data__num">{{ $training->id }}</td>
                            <td><strong>{{ $training->title }}</strong></td>
                            <td>{{ $training->hall->name }}</td>
                            <td class="data__nowrap">{{ $training->starts_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $training->duration_min }}</td>
                            <td>{{ $training->members_count }} / {{ $training->max_people }}</td>
                            <td>
                                @if ($training->is_group) <span class="tag tag--group">Групповая</span>
                                @else <span class="tag">Индивидуальная</span> @endif
                            </td>
                            <td class="data__actions">
                                <a href="{{ route('trainings.edit', $training) }}" class="btn btn--sm btn--ghost">Изменить</a>
                                <form method="POST" action="{{ route('trainings.destroy', $training) }}" class="inline"
                                      onsubmit="return confirm('Удалить запись?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn--sm btn--danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="data__empty">Ничего не найдено. <a href="{{ route('trainings.index') }}">Сбросить фильтры</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $trainings->links() }}
    </div>
@endsection
