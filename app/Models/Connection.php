<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Connection extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user1()
    {
        return $this->belongsTo(User::class,'user_id_1');
    }

    public function user2()
    {
        return $this->belongsTo(User::class,'user_id_2');
    }
}
