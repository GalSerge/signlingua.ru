<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'in_name',
        'latitude',
        'longitude'
    ];

    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class);
    }
}
