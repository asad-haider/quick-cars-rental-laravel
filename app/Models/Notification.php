<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['message', 'sender_id', 'action_type', 'ref_id', 'url'];

    public function users()
    {
        return $this->belongsToMany('App\Models\Auth\User\User')->withPivot('is_sent', 'is_read');
    }

}