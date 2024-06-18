<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Prepare the email details
        $details = [
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
        ];

        try {
            // Send the email
            Mail::to($validatedData['email'])->send(new CustomEmail($details));
            return response()->json(['message' => 'Email sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Error in sending email: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send email'], 500);
        }
    }
}
