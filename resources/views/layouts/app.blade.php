<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Без названия' }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@600;800;900&family=Golos+Text:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lpr.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="wrap site-header__row">
            <a class="brand" href="{{ route('catalog.index') }}">
                <svg class="brand__mark" width="28" height="20" viewBox="0 0 28 20" aria-hidden="true">
                    <rect y="0" width="28" height="5" rx="2.5" fill="currentColor"/>
                    <rect y="7.5" width="17" height="5" rx="2.5" fill="currentColor"/>
                    <rect y="15" width="23" height="5" rx="2.5" fill="currentColor"/>
                </svg>
                {{ config('app.name') }}
            </a>
            <nav class="nav" aria-label="Основное меню">
                <a href="{{ route('catalog.index') }}" @class(['nav__link', 'is-active' => request()->routeIs('catalog.index')])>Расписание</a>
                <a href="{{ route('catalog.hall') }}" @class(['nav__link', 'is-active' => request()->routeIs('catalog.hall')])>Залы</a>
                <a href="{{ route('catalog.stats') }}" @class(['nav__link', 'is-active' => request()->routeIs('catalog.stats')])>Статистика</a>
                <a href="{{ route('feedback.form') }}" @class(['nav__link', 'is-active' => request()->routeIs('feedback.*')])>Обратная связь</a>
            </nav>
        </div>
    </header>

    <main class="page">
        @if (session('status'))
            <div class="wrap">
                <div class="notice">{{ session('status') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="wrap site-footer__row">
            <span>{{ config('lab.student') }} ({{ config('lab.group') }}, N = {{ config('lab.number') }})</span>
            <span>код занятия: <strong class="stamp">{{ config('lab.code') }}</strong></span>
            <span>{{ now()->format('d.m.Y H:i:s') }}</span>
        </div>
    </footer>
</body>
</html>
