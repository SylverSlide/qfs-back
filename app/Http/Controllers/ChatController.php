<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function fetchMessages($questionId)
    {
        $messages = ChatMessage::with('user')
            ->where('question_id', $questionId)
            ->get();
        return response()->json($messages);
    }
    public function store(Request $request)
    {
        $message = ChatMessage::create([
            'user_id' => 1,
            'question_id' => 1,
            'message' => $request->message,
        ]); // Assurez-vous de valider les données
        broadcast(new MessageSent($message))->toOthers(); // Diffusion de l'événement
        return response()->json($message);
    }
}
