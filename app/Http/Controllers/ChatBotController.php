<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\ChatBotService;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    /**
     * Send message to chatbot
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'session_id' => 'required|string|max:100',
        ]);

        $response = ChatBotService::getResponse(
            $validated['message'],
            $validated['session_id']
        );

        return response()->json([
            'success' => true,
            'response' => $response['text'],
            'product_id' => $response['product_id'] ?? null,
            'products' => $response['products'] ?? null,
        ]);
    }

    /**
     * Get chat history
     */
    public function getHistory($sessionId)
    {
        $messages = ChatBotService::getHistory($sessionId);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function($msg) {
                return [
                    'type' => $msg->type,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                ];
            }),
        ]);
    }

    /**
     * Rate conversation
     */
    public function rate(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        ChatBotService::rateConversation(
            $validated['session_id'],
            $validated['rating']
        );

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã đánh giá!',
        ]);
    }

    /**
     * Clear chat
     */
    public function clear(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        ChatMessage::where('session_id', $validated['session_id'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cuộc trò chuyện đã được xóa',
        ]);
    }
}
