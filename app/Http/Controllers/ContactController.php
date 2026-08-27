<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /** Display the Contact Us Page */
    public function index(): View
    {
        $org         = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.contact', compact('org', 'socialLinks'));
    }

    /** Handle the contact form submission */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:120',
            'phone'   => 'nullable|string|max:30',
            'email'   => 'required|email|max:180',
            'subject' => 'required|in:general_inquiry,donation,volunteer,partnership',
            'message' => 'required|string|max:1500',
        ], [
            'name.required'    => 'الاسم الكامل مطلوب.',
            'email.required'   => 'البريد الإلكتروني مطلوب.',
            'email.email'      => 'يرجى إدخال عنوان بريد إلكتروني صحيح.',
            'subject.required' => 'يرجى تحديد موضوع الرسالة.',
            'message.required' => 'يرجى كتابة نص الرسالة.',
        ]);

        // Note: You can store the contact request in a database or send an email here.
        // For now, we will redirect back smoothly with a success token.

        return redirect()->route('contact')
            ->with('contact_success', true);
    }
}