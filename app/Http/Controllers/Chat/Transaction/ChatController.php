<?php

namespace App\Http\Controllers\Chat\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function index() {
        return view('chat.transaction.chat.chat-index');
    }
}
