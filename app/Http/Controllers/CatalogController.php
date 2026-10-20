<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Временное хранилище: в ЛПР № 9 его заменит база данных.
    // Ровно ITEMS = 6 записей. Код: 3 буквы, дефис, 5 цифр (CODE_L = 3, CODE_D = 5).
    // ВАЖНО: замените данные на свои.
    private function trainings(): array
    {
        return [
            ['id' => 1, 'code' => 'YOG-00101', 'title' => 'Утренняя йога', 'hall' => 'Зал йоги',
             'starts_at' => '2026-10-19 08:00', 'duration_min' => 60, 'max_people' => 15, 'is_group' => true],
            ['id' => 2, 'code' => 'BOX-00202', 'title' => 'Бокс для начинающих', 'hall' => 'Зал бокса',
             'starts_at' => '2026-10-19 19:00', 'duration_min' => 90, 'max_people' => 12, 'is_group' => true],
            ['id' => 3, 'code' => 'GYM-00303', 'title' => 'Силовая тренировка', 'hall' => 'Тренажёрный зал',
             'starts_at' => '2026-10-20 10:00', 'duration_min' => 75, 'max_people' => 8, 'is_group' => false],
            ['id' => 4, 'code' => 'YOG-00104', 'title' => 'Хатха-йога', 'hall' => 'Зал йоги',
             'starts_at' => '2026-10-21 18:30', 'duration_min' => 80, 'max_people' => 10, 'is_group' => true],
            ['id' => 5, 'code' => 'BOX-00205', 'title' => 'Персональный спарринг', 'hall' => 'Зал бокса',
             'starts_at' => '2026-10-22 17:00', 'duration_min' => 45, 'max_people' => 2, 'is_group' => false],
            ['id' => 6, 'code' => 'GYM-00306', 'title' => 'Кардио-интенсив', 'hall' => 'Тренажёрный зал',
             'starts_at' => '2026-10-23 07:30', 'duration_min' => 50, 'max_people' => 20, 'is_group' => true],
        ];
    }

    // GET /catalog?q=...&sort=...
    public function index(Request $request)
    {
        $trainings = collect($this->trainings());

        $search = $request->query('q');
        if ($search) {
            $trainings = $trainings->filter(fn ($t) => mb_stripos($t['title'], $search) !== false);
        }

        $sort = $request->query('sort', 'title');
        if (in_array($sort, ['title', 'starts_at', 'duration_min'])) {
            $trainings = $trainings->sortBy($sort);
        }

        return view('catalog.index', [
            'title' => 'Расписание тренировок',
            'trainings' => $trainings,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    // GET /catalog/3
    public function show(int $id)
    {
        $training = collect($this->trainings())->firstWhere('id', $id);
        abort_if(! $training, 404);

        return view('catalog.show', ['title' => $training['title'], 'training' => $training]);
    }

    // GET /catalog/code/YOG-00101
    public function byCode(string $code)
    {
        $training = collect($this->trainings())->firstWhere('code', $code);
        abort_if(! $training, 404);

        return view('catalog.show', ['title' => $training['title'], 'training' => $training]);
    }

    // GET /catalog/hall/Зал йоги  или  /catalog/hall
    public function byHall(?string $hall = null)
    {
        $all = collect($this->trainings());

        // ⭐ задание 2: без параметра — список залов, а не все записи
        if (! $hall) {
            return view('catalog.halls', [
                'title' => 'Все залы',
                'halls' => $all->pluck('hall')->unique(),
            ]);
        }

        return view('catalog.index', [
            'title' => "Тренировки: {$hall}",
            'trainings' => $all->where('hall', $hall),
            'search' => null,
            'sort' => 'title',
        ]);
    }

    // ⭐ задание 1: GET /catalog/stats
    public function stats()
    {
        $c = collect($this->trainings());

        return view('catalog.stats', [
            'title' => 'Статистика',
            'count' => $c->count(),
            'avg' => $c->avg('duration_min'),
            'min' => $c->min('duration_min'),
            'max' => $c->max('duration_min'),
        ]);
    }
}
