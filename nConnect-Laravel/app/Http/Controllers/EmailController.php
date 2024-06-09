<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);


        $name = $validatedData['name'] ;
        $email = $validatedData['email'];
        $message = $validatedData['message'];

        Mail::to('nconnectsk@gmail.com')->send(new SendEmail($name, $email, $message));
        return response()->json('Email sent');
    }
}
