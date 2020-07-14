<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public $timestamp = true;

    public function companies()
    {
        return $this->hasMany(Company::class, 'category_id', 'id');
    }
}
