<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function show($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $messages = $conversation->messages()->latest()->get();
        $conversations = Auth::user()->conversations;

        return view('conversations.show', compact('conversation', 'messages', 'conversations'));
    }

    public function send(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:10240',
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        // Guardar el archivo si existe
        $attachment = null;
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->store('chat_attachments', 'public');
        }

        // Crear el mensaje
        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = Auth::id();
        $message->content = $request->input('content');
        $message->attachment = $attachment;
        $message->save();

        return redirect()->route('conversations.show', $conversation->id);
    }

    public function create()
    {
        $user = Auth::user();


        if ($user->can('viewAny', Conversation::class)) 
        {
            $users = User::whereNull('deleted_at')
            ->orderBy("name","asc")
            ->where("users.id","<>",$user->id)
            ->get()
            ->map(function($user) {
                return [
                    'value' => $user->user_id,
                    'label' => $user->user_id . ' (' . $user->email . ')'  // Combinando id y email
                ];
            });
        }
        else
        {
            // UN USUARIO SOLO PUEDE VER SUPERADMIN Y ADMINS
            $users = User::join('roles_users', 'users.id', '=', 'roles_users.user_id')
            ->join('roles', 'roles_users.role_id', '=', 'roles.id')
            ->whereNull('users.deleted_at')
            ->where("users.id","<>",$user->id)
            ->whereIn('roles.id', [1, 2])
            ->orderBy("users.name","asc")
            ->get()
            ->map(function($user) {
                return [
                    'value' => $user->user_id,
                    'label' => $user->user_id . ' (' . $user->email . ')'  // Combinando id y email
                ];
            });
        }

        

        return view('conversations.create',compact("users"));
    }

    public function index()
    {
        $user = Auth::user();


        if ($user->can('viewAny', Conversation::class)) 
        {
            $conversations = Conversation::orderBy("created_at","desc")->paginate(10);
        }
        else 
        {
            $conversations = Conversation::whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id)->orderBy("updated_at","desc");
            })->orderBy("created_at","desc")->paginate(10);
        }
    
        return view('conversations.index', compact('conversations'));
    }

    public function store(Request $request)
    {
        $conversation = new Conversation();
        
        $user = User::find($request->user_id_selected);

        // SI EL USUARIO ELEGIDO NO TIENE ROL USUARIO SE LE ASIGNA AL USUARIO DE SESION
        if (!$user->roles->contains('name', 'User')) 
        {
            $user = User::find(Auth::id());
        }
        
        // CREATE CONVERSATION
       
        $conversation->name = "Chat User $user->id";
        $conversation->is_group = 1; // es un grupo
        $conversation->created_by = Auth::id();
        $conversation->save();

        // ADD CONVERSATIONS_USERS

        // Agregar el creador y usuario elegido como participante
        $conversation->participants()->attach([
            Auth::id() => ['joined_at' => now()],
            $request->user_id_selected => ['joined_at' => now()],
        ]);

        return redirect()->route('conversations.show', $conversation->id);
    }

    public function edit(Conversation $conversation)
    {
        $users = User::whereNull('users.deleted_at') // Condición para verificar que 'deleted_at' es NULL
                ->whereNotExists(function ($query) {
                    $query->select("id")
                        ->from('conversations_users as cu')
                        ->whereColumn('cu.user_id', 'users.id') // Correlación entre 'user_id' y 'u.id'
                        ->where('cu.conversation_id', 5);  // Filtrar por 'conversation_id'
                })
                ->orderBy("name","asc")
                ->orderBy("id","asc")
                ->get()
                ->map(function($user) {
                    return [
                        'value' => $user->id,
                        'label' => $user->id . ' (' . $user->email . ')'  // Combinando id y email
                    ];
                });
        return view('conversations.edit', compact('conversation',"users"));
    }

    public function addParticipant(Conversation $conversation, Request $request)
    {
        $user = User::find($request->user_id_selected);
        $conversation->participants()->attach($user->id, ['joined_at' => now()]);
        return redirect()->route('conversations.edit', $conversation->id);
    }

    public function removeParticipant(Conversation $conversation, User $user)
    {
        $conversation->participants()->detach($user->id);
        return redirect()->route('conversations.edit', $conversation->id);
    }

    public function update($request)
    {
        dd($request);
    }
}
