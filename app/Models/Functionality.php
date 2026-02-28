<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functionality extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany(Functionality::class, 'parent_id')
                    ->where('target','menu')
                    ->with('children')
                    ->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(Functionality::class, 'parent_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_functionalities');
    }
}
