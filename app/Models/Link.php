<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['project_id', 'name', 'url', 'icon', 'hidden', 'order'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}