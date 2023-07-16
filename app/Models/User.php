<?php

namespace App\Models;

use App\Models\ConnectionRequest;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sentConnectionRequests()
    {
        return $this->hasMany(ConnectionRequest::class, 'sender_id');
    }

    public function receivedConnectionRequests()
    {
        return $this->hasMany(ConnectionRequest::class, 'receiver_id');
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id_1', 'user_id_2');
    }

    public function connectionsInCommon(User $user)
    {
        return $this->connections()->whereIn('user_id_2', $user->connections->pluck('id'));
    }


    public function suggestions()
    {
        return User::whereDoesntHave('connections', function (Builder $query) {
                $query->where('user_id_2', $this->id);
            })
            ->whereDoesntHave('receivedConnectionRequests', function (Builder $query) {
                $query->where('sender_id', $this->id);
            })
            ->whereDoesntHave('sentConnectionRequests', function (Builder $query) {
                $query->where('receiver_id', $this->id);
            })
            ->where('id', '!=', $this->id);
    }

}
