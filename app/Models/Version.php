<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    public $timestamps = false; // Disable timestamps

    protected $fillable = ['project_id', 'version_number', 'description', 'date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}