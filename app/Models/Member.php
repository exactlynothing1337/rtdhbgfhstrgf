<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'phone'];

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }
}
