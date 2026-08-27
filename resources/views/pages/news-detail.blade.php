@extends('layouts.app')
@section('title', $article->title)

@section('content')

<section class="relative">
    <div class="h-[380px] overflow-hidden">
        <img src="{{ $article->cover_image_url }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-rahma-green-900 via-rahma-green-900/40 to-transparent"></div>
    </div>
    <div class="absolute bottom-0 inset-x-0">
        <div class="max-w-4xl mx-auto px-4 pb-10 text-white">
            <span class="flex items-center gap-2 text-rahma-gold-300 font-bold text-sm mb-3"><i data-lucide="calendar"></i> {{ optional($article->published_at)->format('d M Y') }}</span>
            <h1 class="text-3xl lg:text-4xl font-black">{{ $article->title }}</h1>
        </div>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl p-8 shadow-soft">
        <p class="text-rahma-green-900/80 leading-9 whitespace-pre-line text-lg">{{ $article->content }}</p>
    </div>

    <div class="flex gap-3 mt-8">
        @foreach($socialLinks as $link)
            <a href="{{ $link->url }}" target="_blank" class="w-11 h-11 rounded-full bg-rahma-green-50 hover:bg-rahma-green-500 flex items-center justify-center transition">
                <x-social-icon :link="$link" class="w-5 h-5" />
            </a>
        @endforeach
    </div>
</section>

@if($related->count())
<section class="bg-rahma-green-50/60 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-black text-rahma-green-800 mb-8">{{ app()->getLocale()==='en' ? 'Related Articles' : 'مقالات ذات صلة' }}</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $r)
                <a href="{{ route('news.show', $r->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-2xl transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $r->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-rahma-green-800 line-clamp-2">{{ $r->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection