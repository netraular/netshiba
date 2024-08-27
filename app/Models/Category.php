<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'class'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}