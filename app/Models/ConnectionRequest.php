<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConnectionRequest extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function userSender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function userReceiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
