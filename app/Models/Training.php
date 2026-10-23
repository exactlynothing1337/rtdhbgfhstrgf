<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    use HasFactory;

    // поля, которые разрешено заполнять массово: Training::create([...]), $training->update([...])
    protected $fillable = ['hall_id', 'title', 'description', 'starts_at', 'duration_min', 'max_people', 'is_group'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'is_group'  => 'boolean',
        ];
    }

    public function hall(): BelongsTo               // тренировка проходит в одном зале
    {
        return $this->belongsTo(Hall::class);
    }

    public function members(): BelongsToMany        // ⭐ записанные участники
    {
        return $this->belongsToMany(Member::class);
    }
}
