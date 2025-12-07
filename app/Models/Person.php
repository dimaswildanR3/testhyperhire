<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'latitude', 'longitude'];

    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
