<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area'];

    public function trainings(): HasMany            // в одном зале — много тренировок
    {
        return $this->hasMany(Training::class);
    }
}
