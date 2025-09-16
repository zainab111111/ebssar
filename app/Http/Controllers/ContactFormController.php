<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store into DB
        $contactForm = new ContactForm();
        $contactForm->name = $validated['name'];
        $contactForm->email = $validated['email'];
        $contactForm->subject = $validated['subject'];
        $contactForm->message = $validated['message'];
        $contactForm->save();

        // Redirect back with success
        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }
}
