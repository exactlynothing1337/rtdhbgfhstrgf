<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingRequest;
use App\Models\Hall;
use App\Models\Member;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TrainingController extends Controller
{
    // GET /trainings?q=...&hall_id=...&group=...
    public function index(Request $request)
    {
        $query = Training::with('hall')->withCount('members');   // жадная загрузка связи

        if ($search = $request->query('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        // ⭐ 1: фильтр по родителю и по логическому полю
        if ($hallId = $request->query('hall_id')) {
            $query->where('hall_id', $hallId);
        }
        $group = $request->query('group');
        if ($group === '1' || $group === '0') {
            $query->where('is_group', $group === '1');
        }

        $query->orderBy('title');                                // SORT: N = 7 (нечётный) → по названию А→Я

        return view('trainings.index', [
            'title'     => 'Тренировки',
            'trainings' => $query->paginate(6)->withQueryString(),   // PER_PAGE = 3 + (7 mod 4) = 6
            'halls'     => Hall::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('trainings.form', $this->formData('Новая тренировка', new Training()));
    }

    public function store(TrainingRequest $request)
    {
        $data = $request->validated();                           // только проверенные поля
        $training = Training::create(Arr::except($data, 'member_ids'));
        $training->members()->sync($data['member_ids'] ?? []);   // ⭐ 3: sync() по флажкам

        return redirect()->route('trainings.index')
            ->with('status', "Добавлено: {$training->title} (id {$training->id})");
    }

    public function edit(Training $training)                     // запись найдена по {training} автоматически
    {
        return view('trainings.form', $this->formData('Редактирование', $training));
    }

    public function update(TrainingRequest $request, Training $training)
    {
        $data = $request->validated();
        $training->update(Arr::except($data, 'member_ids'));
        $training->members()->sync($data['member_ids'] ?? []);

        return redirect()->route('trainings.index')->with('status', 'Изменения сохранены.');
    }

    public function destroy(Training $training)
    {
        $training->delete();                                     // строки pivot удалит каскад

        return redirect()->route('trainings.index')->with('status', "Удалено: {$training->title}");
    }

    private function formData(string $title, Training $training): array
    {
        return [
            'title'    => $title,
            'training' => $training,
            'halls'    => Hall::orderBy('name')->get(),
            'members'  => Member::orderBy('full_name')->get(),
            'selected' => $training->exists ? $training->members()->pluck('members.id')->all() : [],
        ];
    }
}
