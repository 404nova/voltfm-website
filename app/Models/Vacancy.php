<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];
	public function sollicitaties()
{
    return $this->hasMany(Vacature::class);
}

}
