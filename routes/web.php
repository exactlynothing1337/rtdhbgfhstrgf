<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('catalog.index'));

Route::prefix('catalog')->name('catalog.')->controller(CatalogController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/stats', 'stats')->name('stats'); // ⭐ объявлен выше /{id}, плюс whereNumber у /{id}
    Route::get('/hall/{hall?}', 'byHall')->name('hall');
    Route::get('/code/{code}', 'byCode')
        ->where('code', '[A-Z]{3}-[0-9]{5}')->name('code'); // CODE_L = 3 буквы, CODE_D = 5 цифр
    Route::get('/{id}', 'show')->whereNumber('id')->name('show');
});

// ЛПР № 9: CRUD на базе данных (show не используется)
Route::resource('trainings', TrainingController::class)->except(['show']);
Route::resource('halls', HallController::class)->except(['show']);

Route::get('/feedback', [PageController::class, 'feedbackForm'])->name('feedback.form');
Route::post('/feedback', [PageController::class, 'feedbackSend'])->name('feedback.send');

// Исправление из наблюдения 2: \p{L} — любая буква (в т.ч. кириллица)
Route::get('/hello/{name?}', function (string $name = 'гость') {
    return "Привет, {$name}!";
})->where('name', '\p{L}+');
