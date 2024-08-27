<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name', 'description', 'hidden','class'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}