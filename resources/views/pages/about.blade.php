@extends('layouts.app')
@section('title', ($org->name ?? '') . ' | ' . (app()->getLocale()==='en' ? 'About Us' : 'من نحن'))

@section('content')

<section class="relative bg-rahma-gradient overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-5xl mx-auto px-4 py-20 text-center text-white relative">
        <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-rahma-gold-200 text-xs font-bold px-4 py-1.5 rounded-full mb-6">
            <i data-lucide="info"></i> {{ app()->getLocale()==='en' ? 'About Us' : 'من نحن' }}
        </span>
        <h1 class="text-4xl lg:text-5xl font-black mb-6">{{ $org->name }}</h1>
        <p class="text-rahma-green-50/90 text-lg leading-8 max-w-3xl mx-auto">{{ $org->about_text }}</p>
    </div>
    <svg class="w-full text-rahma-cream" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

{{-- Vision & Mission --}}
<section class="max-w-6xl mx-auto px-4 py-20 grid md:grid-cols-2 gap-8">
    <div class="bg-white rounded-3xl p-10 shadow-soft border-t-4 border-rahma-green-500">
        <div class="w-14 h-14 rounded-2xl bg-rahma-green-50 flex items-center justify-center mb-6">
            <i data-lucide="eye" class="text-2xl text-rahma-green-600"></i>
        </div>
        <h3 class="text-2xl font-black text-rahma-green-800 mb-3">{{ app()->getLocale()==='en' ? 'Our Vision' : 'رؤيتنا' }}</h3>
        <p class="text-rahma-green-900/70 leading-8">{{ $org->vision }}</p>
    </div>
    <div class="bg-white rounded-3xl p-10 shadow-soft border-t-4 border-rahma-gold-500">
        <div class="w-14 h-14 rounded-2xl bg-rahma-gold-50 flex items-center justify-center mb-6">
            <i data-lucide="target" class="text-2xl text-rahma-gold-600"></i>
        </div>
        <h3 class="text-2xl font-black text-rahma-green-800 mb-3">{{ app()->getLocale()==='en' ? 'Our Mission' : 'رسالتنا' }}</h3>
        <p class="text-rahma-green-900/70 leading-8">{{ $org->mission }}</p>
    </div>
</section>

{{-- Impact Stats --}}
<section class="bg-rahma-green-50/60 py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($impactStats as $stat)
                <div class="bg-white rounded-2xl shadow-soft p-6 text-center hover:-translate-y-1 transition">
                    <i data-lucide="{{ $stat->icon_name ?? 'star' }}" class="text-3xl text-rahma-green-600 mb-3"></i>
                    <div class="text-3xl font-black text-rahma-green-700">{{ $stat->display_value }}</div>
                    <div class="text-sm text-rahma-green-900/70 font-semibold mt-1">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Awards --}}
@if($awards->count())
<section class="max-w-7xl mx-auto px-4 py-20">
    <div class="text-center max-w-2xl mx-auto mb-14">
        <span class="text-rahma-gold-600 font-bold text-sm">{{ app()->getLocale()==='en' ? 'Recognition' : 'شهادات التميز' }}</span>
        <h2 class="text-3xl lg:text-4xl font-black text-rahma-green-800 mt-2">{{ app()->getLocale()==='en' ? 'Awards & Honors' : 'جوائزنا وأوسمتنا' }}</h2>
    </div>
    <div class="grid md:grid-cols-2 gap-8">
        @foreach($awards as $award)
            <div class="flex gap-5 bg-white rounded-3xl p-6 shadow-soft hover:shadow-2xl transition">
                <img src="{{ $award->image_url }}" class="w-24 h-24 rounded-2xl object-cover flex-shrink-0">
                <div>
                    <span class="text-xs font-bold text-rahma-gold-600">{{ $award->year }}</span>
                    <h3 class="font-bold text-rahma-green-800 mt-1 mb-2">{{ $award->title }}</h3>
                    <p class="text-sm text-rahma-green-900/60">{{ $award->description }}</p>
                    @if($award->issuer)<p class="text-xs text-rahma-green-500 mt-2 font-semibold">{{ $award->issuer }}</p>@endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- Partners --}}
@if($partners->count())
<section class="bg-white border-t border-rahma-green-100 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="text-rahma-gold-600 font-bold text-sm">{{ app()->getLocale()==='en' ? 'Our Partners' : 'شركاء النجاح' }}</span>
        <div class="flex flex-wrap justify-center items-center gap-10 mt-8">
            @foreach($partners as $partner)
                <div class="text-rahma-green-700 font-bold text-sm px-4 py-2 rounded-full bg-rahma-green-50">{{ $partner->name }}</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="max-w-7xl mx-auto px-4 py-20 text-center">
    <h2 class="text-2xl lg:text-3xl font-black text-rahma-green-800 mb-6">{{ app()->getLocale()==='en' ? 'Join us in making a change' : 'انضم إلينا في صناعة التغيير' }}</h2>
    <a href="{{ route('donate') }}#volunteer" class="inline-flex items-center gap-2 bg-rahma-gradient text-white font-bold px-8 py-4 rounded-full shadow-soft hover:-translate-y-1 transition">
        <i data-lucide="users"></i> {{ app()->getLocale()==='en' ? 'Become a Volunteer' : 'تطوع معنا' }}
    </a>
</section>

@endsection