<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'category_id', 'status_id', 'logo', 'background', 'complexity', 'order'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

}