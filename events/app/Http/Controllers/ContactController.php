<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Contact\StoreRequest; 


class ContactController extends Controller
{
    public function show()
    {
        return view('contact.form');
    }

    public function submit(StoreRequest  $request)
    {
        // Store the message
        $message = Contact::create($request->validated());

        // Send email to all admin users
        $admins = User::where('is_admin', true)->get();
        
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContactFormMail($message));
        }

        return redirect()
            ->route('contact.show')
            ->with('success', 'Thank you for your message. We will get back to you soon.');
    }
}