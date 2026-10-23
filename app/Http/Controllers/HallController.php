<?php

namespace App\Http\Controllers;

use App\Http\Requests\HallRequest;
use App\Models\Hall;

class HallController extends Controller
{
    // ⭐ 2: список родителей с количеством записей
    public function index()
    {
        return view('halls.index', [
            'title' => 'Залы',
            'halls' => Hall::withCount('trainings')->orderBy('name')->paginate(6),
        ]);
    }

    public function create()
    {
        return view('halls.form', ['title' => 'Новый зал', 'hall' => new Hall()]);
    }

    public function store(HallRequest $request)
    {
        $hall = Hall::create($request->validated());

        return redirect()->route('halls.index')->with('status', "Добавлен зал: {$hall->name} (id {$hall->id})");
    }

    public function edit(Hall $hall)
    {
        return view('halls.form', ['title' => 'Редактирование зала', 'hall' => $hall]);
    }

    public function update(HallRequest $request, Hall $hall)
    {
        $hall->update($request->validated());

        return redirect()->route('halls.index')->with('status', 'Изменения сохранены.');
    }

    // ON_DELETE = cascade: тренировки зала удалятся вместе с ним — сообщаем сколько
    public function destroy(Hall $hall)
    {
        $count = $hall->trainings()->count();
        $hall->delete();

        return redirect()->route('halls.index')
            ->with('status', "Удалён зал «{$hall->name}», вместе с ним удалено тренировок: {$count}");
    }
}
