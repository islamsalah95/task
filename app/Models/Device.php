<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'device_name',
    ];



    public function user()
    {

        return $this->belongsToMany(User::class);



    }

    
}


