@extends('layouts.app')
@section('title', ($org->name ?? '') . ' | ' . (app()->getLocale()==='en' ? 'Contact Us' : 'اتصل بنا'))

@section('content')

<section class="relative bg-rahma-gradient overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-5xl mx-auto px-4 py-16 text-center text-white relative">
        <h1 class="text-4xl lg:text-5xl font-black mb-4">{{ app()->getLocale()==='en' ? 'Get in Touch' : 'تواصل معنا' }}</h1>
        <p class="text-rahma-green-50/90 max-w-2xl mx-auto">{{ app()->getLocale()==='en' ? "We'd love to hear from you" : 'يسعدنا تواصلك معنا في أي وقت' }}</p>
    </div>
    <svg class="w-full text-rahma-cream" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

@if(session('contact_success'))
<div class="max-w-3xl mx-auto mt-8 px-4">
    <div class="bg-rahma-green-50 border border-rahma-green-300 text-rahma-green-800 rounded-2xl p-5 flex items-center gap-3 font-semibold">
        <i data-lucide="check-circle" class="text-2xl text-rahma-green-600"></i>
        {{ app()->getLocale()==='en' ? 'Your message has been sent successfully!' : 'تم إرسال رسالتك بنجاح!' }}
    </div>
</div>
@endif

<section class="max-w-6xl mx-auto px-4 py-16 grid lg:grid-cols-5 gap-10">

    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-3xl p-6 shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rahma-green-50 flex items-center justify-center"><i data-lucide="mail" class="text-rahma-green-600"></i></div>
            <div><div class="text-xs text-rahma-green-900/50">{{ app()->getLocale()==='en' ? 'Email' : 'البريد الإلكتروني' }}</div><div class="font-bold text-rahma-green-800">{{ $org->email }}</div></div>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rahma-gold-50 flex items-center justify-center"><i data-lucide="phone" class="text-rahma-gold-600"></i></div>
            <div><div class="text-xs text-rahma-green-900/50">{{ app()->getLocale()==='en' ? 'Phone' : 'رقم الهاتف' }}</div><div class="font-bold text-rahma-green-800">{{ $org->phone }}</div></div>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rahma-sky-500/10 flex items-center justify-center"><i data-lucide="map-pin" class="text-rahma-sky-500"></i></div>
            <div><div class="text-xs text-rahma-green-900/50">{{ app()->getLocale()==='en' ? 'Address' : 'العنوان' }}</div><div class="font-bold text-rahma-green-800">{{ $org->address }}</div></div>
        </div>
        @if($org->whatsapp_link)
        <a href="{{ $org->whatsapp_link }}" target="_blank" class="bg-rahma-gradient rounded-3xl p-6 shadow-soft flex items-center gap-4 text-white hover:-translate-y-1 transition">
            <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center">
                {{-- "whatsapp" is a brand logo, not a generic Lucide icon — pull it from Simple Icons --}}
                <img src="https://cdn.simpleicons.org/whatsapp/ffffff" class="w-5 h-5" alt="WhatsApp" loading="lazy">
            </div>
            <div><div class="text-xs text-white/70">{{ app()->getLocale()==='en' ? 'Chat with us' : 'تحدث معنا' }}</div><div class="font-bold">WhatsApp</div></div>
        </a>
        @endif
        <div class="flex gap-2 pt-2">
            @foreach($socialLinks as $link)
                <a href="{{ $link->url }}" target="_blank" class="w-11 h-11 rounded-full bg-rahma-green-50 hover:bg-rahma-green-500 flex items-center justify-center transition">
                    <x-social-icon :link="$link" class="w-5 h-5" />
                </a>
            @endforeach
        </div>
    </div>

    <div class="lg:col-span-3">
        <div class="bg-white rounded-3xl p-8 shadow-soft">
            <h2 class="text-xl font-black text-rahma-green-800 mb-6">{{ app()->getLocale()==='en' ? 'Send a Message' : 'أرسل رسالة' }}</h2>
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Full Name' : 'الاسم الكامل' }}</label>
                        <input type="text" name="name" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Phone (optional)' : 'الهاتف (اختياري)' }}</label>
                        <input type="text" name="phone" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Email' : 'البريد الإلكتروني' }}</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                </div>
                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-2 block">{{ app()->getLocale()==='en' ? 'Subject' : 'الموضوع' }}</label>
                    <select name="subject" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                        <option value="general_inquiry">{{ app()->getLocale()==='en' ? 'General Inquiry' : 'استفسار عام' }}</option>
                        <option value="donation">{{ app()->getLocale()==='en' ? 'Donation' : 'تبرع' }}</option>
                        <option value="volunteer">{{ app()->getLocale()==='en' ? 'Volunteering' : 'تطوع' }}</option>
                        <option value="partnership">{{ app()->getLocale()==='en' ? 'Partnership' : 'شراكة' }}</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Message' : 'الرسالة' }}</label>
                    <textarea name="message" rows="5" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400"></textarea>
                </div>
                <button type="submit" class="w-full bg-rahma-gradient text-white font-bold py-4 rounded-full shadow-soft hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
                    <i data-lucide="send"></i> {{ app()->getLocale()==='en' ? 'Send Message' : 'إرسال الرسالة' }}
                </button>
            </form>
        </div>
    </div>
</section>

@endsection