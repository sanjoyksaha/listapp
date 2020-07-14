<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable =[
        'name', 'category_id', 'established_at', 'email', 'website', 'address', 'total_office', 'logo', 'details'
    ];

    public $timestamp = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function age() {
    //     return $this->established_at->diffInYears(Carbon::now());
    // }
}
