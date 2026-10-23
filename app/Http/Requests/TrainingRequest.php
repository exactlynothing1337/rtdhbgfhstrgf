<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;                                     // по умолчанию false → ответ 403
    }

    public function rules(): array
    {
        $trainingId = $this->route('training')?->id;     // при создании — null
        $seats = max(1, (int) $this->input('max_people'));

        return [
            'hall_id'      => ['required', 'integer', 'exists:halls,id'],
            'title'        => ['required', 'string', 'min:3', 'max:121',      // MIN_LEN = 3, STR_LEN = 121
                               Rule::unique('trainings')->where('hall_id', $this->input('hall_id'))
                                   ->ignore($trainingId)],
            'description'  => ['nullable', 'string', 'max:2000'],
            // формат <input type="datetime-local">: 2026-10-23T18:30
            'starts_at'    => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:2020-01-01T00:00'],
            'duration_min' => ['required', 'integer', 'between:10,480'],
            'max_people'   => ['required', 'integer', 'between:1,200'],
            'is_group'     => ['boolean'],
            // ⭐ M:N: список id участников, не больше, чем мест
            'member_ids'   => ['nullable', 'array', 'max:' . $seats],
            'member_ids.*' => ['integer', 'distinct', 'exists:members,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'         => 'Поле «:attribute» обязательно.',
            'title.min'        => 'Название — не менее :min символов.',
            'title.max'        => 'Название — не более :max символов.',
            'title.unique'     => 'В этом зале уже есть тренировка с таким названием.',
            'between'          => 'Поле «:attribute» — от :min до :max.',
            'integer'          => 'Поле «:attribute» должно быть целым числом.',
            'exists'           => 'Выбранное значение поля «:attribute» не найдено в базе.',
            'starts_at.date_format'        => 'Укажите дату и время начала в формате ГГГГ-ММ-ДД ЧЧ:ММ.',
            'starts_at.after_or_equal'     => 'Дата начала не может быть раньше 2020 года.',
            'member_ids.max'   => 'Записано участников больше, чем мест (максимум :max).',
        ];
    }

    public function attributes(): array
    {
        return [
            'hall_id'      => 'Зал',
            'title'        => 'Название',
            'description'  => 'Описание',
            'starts_at'    => 'Начало',
            'duration_min' => 'Длительность, мин',
            'max_people'   => 'Мест',
            'member_ids'   => 'Участники',
            'member_ids.*' => 'Участник',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_group' => $this->boolean('is_group')]);   // неотмеченный checkbox не отправляется
    }
}
