@extends('layouts.app')
@section('title', ($org->name ?? '') . ' | ' . (app()->getLocale()==='en' ? 'News' : 'الأخبار'))

@section('content')

<section class="relative bg-rahma-gradient overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-5xl mx-auto px-4 py-16 text-center text-white relative">
        <h1 class="text-4xl lg:text-5xl font-black mb-4">{{ app()->getLocale()==='en' ? 'Latest News' : 'آخر الأخبار' }}</h1>
        <p class="text-rahma-green-50/90 max-w-2xl mx-auto">{{ app()->getLocale()==='en' ? 'Follow our latest activities and achievements' : 'تابع آخر أنشطتنا وإنجازاتنا' }}</p>
    </div>
    <svg class="w-full text-rahma-cream" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <a href="{{ route('news.show', $article->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="h-52 overflow-hidden">
                    <img src="{{ $article->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <span class="text-xs text-rahma-gold-600 font-bold flex items-center gap-1"><i data-lucide="calendar"></i> {{ optional($article->published_at)->format('d M Y') }}</span>
                    <h3 class="font-bold text-rahma-green-800 mt-2 mb-3 line-clamp-2">{{ $article->title }}</h3>
                    <span class="text-sm font-bold text-rahma-green-600 group-hover:text-rahma-gold-600 transition flex items-center gap-1">
                        {{ app()->getLocale()==='en' ? 'Read More' : 'اقرأ المزيد' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}"></i>
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-14">{{ $articles->links() }}</div>
</section>

@endsection