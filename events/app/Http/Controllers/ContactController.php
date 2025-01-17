<?php

namespace App\Http\Controllers;

use App\Mail\ReplyToContactMail;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Contact\StoreRequest; 
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{
    public function show()
    {
        return view('contact.form');
    }

    public function submit(StoreRequest  $request)
    {
        $message = Contact::create($request->validated());

        $admins = User::where('is_admin', true)->get();
        
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContactFormMail($message));
        }

        return redirect()
            ->route('contact.show')
            ->with('success', 'Thank you for your message. We will get back to you soon.');
    }

     //following 2 methods are adapted from https://chatgpt.com/share/678a7c56-a698-8007-bfa7-4713a61b9b0d
     public function index(Request $request)
     {
         $query = Contact::latest();
     
         // Handle search
         if ($request->has('search')) {
             $search = $request->get('search');
             $query->where(function($q) use ($search) {
                 $q->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%")
                   ->orWhere('subject', 'like', "%{$search}%");
             });
         }
     
         // Handle reply status filter
         if ($request->has('replied') && $request->replied !== '') {
             $query->where('replied', $request->replied);
         }
     
         $contacts = $query->paginate(10);
         
         return view('admin.contacts.index', compact('contacts'));
     }
     
     public function reply(Request $request, Contact $contact)
     {
         $validated = $request->validate([
             'reply_message' => 'required|string', // Match the form field name
         ]);
     
         // Update the contact record
         $contact->update([
             'replied' => true,
             'reply_message' => $validated['reply_message']
         ]);
     
         // Send email
         Mail::to($contact->email)->send(new ReplyToContactMail($validated['reply_message']));
     
         return redirect()
             ->route('admin.contacts.index')
             ->with('success', 'Reply sent successfully.');
 
 
  
            }


            public function destroy(Contact $contact)
{
    $contact->delete();
    return redirect()
        ->route('admin.contacts.index')
        ->with('success', 'Message deleted successfully.');
}
}