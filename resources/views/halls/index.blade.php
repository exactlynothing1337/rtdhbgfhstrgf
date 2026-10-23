@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="wrap">
            <div class="hero__row">
                <h1 class="hero__title">{{ $title }}</h1>
                <a href="{{ route('halls.create') }}" class="btn">+ Добавить</a>
            </div>
            <p class="hero__meta">Всего залов: {{ $halls->total() }}</p>
        </div>
    </section>

    <div class="wrap section">
        <div class="table-scroll">
            <table class="data">
                <thead><tr><th>#</th><th>Название</th><th>Площадь, м²</th><th>Тренировок</th><th></th></tr></thead>
                <tbody>
                    @forelse ($halls as $hall)
                        <tr>
                            <td class="data__num">{{ $hall->id }}</td>
                            <td><strong>{{ $hall->name }}</strong></td>
                            <td>{{ $hall->area }}</td>
                            <td><a href="{{ route('trainings.index', ['hall_id' => $hall->id]) }}">{{ $hall->trainings_count }}</a></td>
                            <td class="data__actions">
                                <a href="{{ route('halls.edit', $hall) }}" class="btn btn--sm btn--ghost">Изменить</a>
                                {{-- ON_DELETE = cascade: предупреждаем, сколько тренировок исчезнет вместе с залом --}}
                                <form method="POST" action="{{ route('halls.destroy', $hall) }}" class="inline"
                                      onsubmit="return confirm(@js("Удалить зал «{$hall->name}»? Вместе с ним будет удалено тренировок: {$hall->trainings_count}"))">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn--sm btn--danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="data__empty">Залов пока нет.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $halls->links() }}
    </div>
@endsection
