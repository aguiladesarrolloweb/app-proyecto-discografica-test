<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessagesRead extends Model
{
    protected $fillable = ['message_id', 'user_id', 'read_at'];

    /**
     * El mensaje que fue leído.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * El usuario que leyó el mensaje.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
