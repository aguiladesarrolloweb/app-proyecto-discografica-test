<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'content', 'attachment'];

    /**
     * La conversación a la que pertenece el mensaje.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * El usuario que envió el mensaje.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Los registros de lectura del mensaje.
     */
    public function reads()
    {
        return $this->hasMany(MessagesRead::class,"messages_reads");
    }
}
