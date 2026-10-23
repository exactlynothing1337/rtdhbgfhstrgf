<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100',
                       Rule::unique('halls')->ignore($this->route('hall')?->id)],
            'area' => ['required', 'integer', 'between:5,5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'    => 'Поле «:attribute» обязательно.',
            'name.min'    => 'Название — не менее :min символов.',
            'name.unique' => 'Зал с таким названием уже есть.',
            'between'     => 'Поле «:attribute» — от :min до :max.',
            'integer'     => 'Поле «:attribute» должно быть целым числом.',
        ];
    }

    public function attributes(): array
    {
        return ['name' => 'Название', 'area' => 'Площадь, м²'];
    }
}
