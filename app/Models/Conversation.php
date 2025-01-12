<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['name', 'is_group', 'created_by'];

    /**
     * La relación inversa con el creador de la conversación.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * La relación muchos a muchos con los participantes.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class,"conversations_users")->withPivot('joined_at');
    }

    /**
     * Los mensajes de la conversación.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
