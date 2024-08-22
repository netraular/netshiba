<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['project_id', 'explanation'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
