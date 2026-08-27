@extends('layouts.app')
@section('title', ($org->name ?? 'متراحمين الخيرية') . ' | ' . (app()->getLocale()==='en' ? 'Home' : 'الرئيسية'))

@push('styles')
    {{-- Swiper CSS for the Slider --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Partner Marquee Animation */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 1rem)); }
        }
        .animate-marquee {
            animation: scroll 20s linear infinite;
        }
        /* Custom Swiper Pagination Colors */
        .swiper-pagination-bullet { background: rgba(255, 255, 255, 0.5); }
        .swiper-pagination-bullet-active { background: #FCD34D; /* rahma-gold */ }
    </style>
@endpush

@section('content')

{{-- ============ HERO SLIDER ============ --}}
<section class="relative bg-rahma-gradient pt-20 pb-32 lg:pt-28 lg:pb-40">
    <div class="absolute inset-0 dotted-pattern opacity-50"></div>
    <div class="absolute -top-24 -start-24 w-96 h-96 bg-rahma-gold-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -end-10 w-96 h-96 bg-rahma-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="swiper heroSwiper max-w-7xl mx-auto px-4 relative z-10 overflow-visible">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $slide)
                @php
                    $locale = app()->getLocale();
                    $headline    = $locale === 'en' ? ($slide->headline_en ?? $slide->headline_ar) : $slide->headline_ar;
                    $headline    = $headline ?: ($org->name ?? '');
                    $highlighted = $locale === 'en' ? ($slide->highlighted_text_en ?? $slide->highlighted_text_ar) : $slide->highlighted_text_ar;
                    $subtext     = $locale === 'en' ? ($slide->subtext_en ?? $slide->subtext_ar) : $slide->subtext_ar;
                    $subtext     = $subtext ?: ($org->marketing_message ?? '');
                    $ctaLabel    = $locale === 'en' ? ($slide->cta_label_en ?? $slide->cta_label_ar) : $slide->cta_label_ar;

                    $before = $headline;
                    $after  = '';
                    if ($highlighted) {
                        $pos = mb_stripos($headline, $highlighted);
                        if ($pos !== false) {
                            $before = mb_substr($headline, 0, $pos);
                            $after  = mb_substr($headline, $pos + mb_strlen($highlighted));
                        }
                    }
                @endphp

                <div class="swiper-slide cursor-grab active:cursor-grabbing">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        {{-- Text Content --}}
                        <div class="text-white text-center lg:text-start">
                            <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-rahma-gold-200 text-xs font-bold px-5 py-2 rounded-full mb-6">
                                <i data-lucide="sparkles" class="w-4 h-4"></i> {{ app()->getLocale()==='en' ? 'Since 2004' : 'منذ عام 2004' }}
                            </span>
                            <h1 class="text-4xl md:text-5xl lg:text-7xl font-black leading-tight mb-6 tracking-tight">
                                {{ $before }}
                                @if($highlighted)
                                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-rahma-gold-300 to-rahma-gold-500 drop-shadow-sm">{{ $highlighted }}</span>{{ $after }}
                                @endif
                            </h1>
                            <p class="text-rahma-green-50/90 text-lg md:text-xl leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
                                {{ $subtext }}
                            </p>
                            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                <a href="{{ $slide->cta_url ?? route('donate') }}" class="bg-rahma-gold-gradient font-bold text-rahma-green-900 px-8 py-4 rounded-full shadow-[0_0_20px_rgba(252,211,77,0.3)] hover:shadow-[0_0_30px_rgba(252,211,77,0.5)] hover:-translate-y-1 transition-all flex items-center gap-2">
                                    <i data-lucide="heart-handshake"></i> {{ $ctaLabel ?? (app()->getLocale()==='en' ? 'Donate Now' : 'تبرع الآن') }}
                                </a>
                                <a href="{{ route('about') }}" class="bg-white/10 backdrop-blur-sm border border-white/30 font-bold px-8 py-4 rounded-full hover:bg-white/20 hover:-translate-y-1 transition-all flex items-center gap-2">
                                    {{ app()->getLocale()==='en' ? 'Learn More' : 'اعرف المزيد' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Image Content --}}
                        <div class="relative w-full max-w-lg mx-auto lg:max-w-none">
                            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl ring-8 ring-white/10 aspect-[4/3] group">
                                <img src="{{ $slide->image_url ?? 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1200&q=80' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" alt="hero slide">
                                <div class="absolute inset-0 bg-gradient-to-t from-rahma-green-900/60 to-transparent"></div>
                            </div>
                            
                            {{-- Floating Glassmorphism Badge --}}
                            <div class="absolute -bottom-6 -start-6 bg-white/90 backdrop-blur-md text-rahma-green-800 rounded-2xl px-6 py-4 shadow-xl border border-white/50 flex items-center gap-4 animate-bounce-slow">
                                <div class="w-12 h-12 rounded-full bg-rahma-sky-100 flex items-center justify-center">
                                    <i data-lucide="droplets" class="text-rahma-sky-500"></i>
                                </div>
                                <div>
                                    <div class="font-black text-xl">500K+</div>
                                    <div class="text-xs font-bold text-rahma-green-600 uppercase tracking-wide">{{ app()->getLocale()==='en' ? 'Beneficiaries' : 'مستفيد' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Pagination Dots --}}
        <div class="swiper-pagination !bottom-0 mt-8 relative"></div>
    </div>
    
    {{-- Decorative Curved Bottom --}}
    <svg class="absolute -bottom-1 w-full text-rahma-cream h-12 lg:h-24 object-cover" preserveAspectRatio="none" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

{{-- ============ IMPACT STATS (Overlapping Hero) ============ --}}
<section class="max-w-7xl mx-auto px-4 -mt-16 lg:-mt-24 relative z-20">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($impactStats as $stat)
            <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-8 text-center border border-white/50 hover:-translate-y-2 hover:shadow-2xl hover:bg-white transition-all duration-300 group">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-rahma-gold-50 group-hover:bg-rahma-gold-500 flex items-center justify-center transition-colors duration-300">
                    <i data-lucide="{{ $stat->icon_name ?? 'star' }}" class="text-rahma-gold-500 group-hover:text-white text-2xl transition-colors duration-300"></i>
                </div>
                <div class="text-4xl font-black text-rahma-green-800">{{ $stat->display_value }}</div>
                <div class="text-sm text-rahma-green-600 font-bold mt-2 tracking-wide">{{ $stat->label }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ CATEGORIES ============ --}}
<section class="max-w-7xl mx-auto px-4 py-28">
    <div class="flex flex-col items-center text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-rahma-gold-100 text-rahma-gold-700 font-bold text-xs uppercase tracking-wider mb-3">{{ app()->getLocale()==='en' ? 'What We Do' : 'مجالات عملنا' }}</span>
        <h2 class="text-3xl md:text-5xl font-black text-rahma-green-900">{{ app()->getLocale()==='en' ? 'Our Focus Areas' : 'مجالات المساهمة الاجتماعية' }}</h2>
    </div>
    
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($categories as $cat)
            <a href="{{ route('projects', ['category' => $cat->id]) }}" class="group relative bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 text-center flex flex-col items-center">
                <div class="absolute inset-0 bg-rahma-gradient opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-20 h-20 mb-6 rounded-2xl bg-rahma-green-50 group-hover:bg-white/20 flex items-center justify-center shadow-inner transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="{{ $cat->icon_name ?? 'heart' }}" class="text-3xl text-rahma-green-600 group-hover:text-rahma-gold-300"></i>
                </div>
                <h3 class="relative z-10 text-xl font-bold text-rahma-green-900 group-hover:text-white transition-colors mb-2">{{ $cat->name }}</h3>
                <span class="relative z-10 text-sm bg-gray-100 group-hover:bg-white/20 text-gray-600 group-hover:text-white py-1 px-3 rounded-full font-semibold transition-colors">{{ $cat->projects_count }} {{ app()->getLocale()==='en' ? 'projects' : 'مشروع' }}</span>
            </a>
        @endforeach
    </div>
</section>

{{-- ============ FEATURED PROJECTS ============ --}}
<section class="bg-rahma-green-50 py-28 relative">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-rahma-green-200/50 rounded-full blur-3xl"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-rahma-gold-200/40 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span class="text-rahma-gold-600 font-bold text-sm uppercase tracking-wider">{{ app()->getLocale()==='en' ? 'Make a Difference' : 'صنع الأثر' }}</span>
                <h2 class="text-3xl md:text-5xl font-black text-rahma-green-900 mt-2">{{ app()->getLocale()==='en' ? 'Featured Projects' : 'المشاريع المميزة' }}</h2>
            </div>
            <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 font-bold text-rahma-green-700 bg-white px-6 py-3 rounded-full shadow-sm hover:shadow-md hover:text-rahma-green-900 hover:-translate-y-1 transition-all">
                {{ app()->getLocale()==='en' ? 'View All' : 'عرض الكل' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProjects as $project)
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-300 flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $project->coverImage->url ?? 'https://images.unsplash.com/photo-1541913496-2246de0d56c4?auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="absolute top-4 {{ app()->getLocale()==='ar' ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm text-rahma-green-900 text-xs font-black px-4 py-1.5 rounded-full shadow-sm">{{ $project->category->name ?? '' }}</span>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-xl text-rahma-green-900 mb-3 line-clamp-2 group-hover:text-rahma-gold-600 transition-colors">{{ $project->title }}</h3>
                        <p class="text-sm text-gray-500 mb-6 line-clamp-2 flex-grow">{{ $project->short_description }}</p>
                        
                        <div>
                            <div class="flex justify-between text-sm font-bold text-rahma-green-800 mb-2">
                                <span>{{ $project->progress_percentage }}%</span>
                                <span class="text-rahma-gold-600">{{ number_format($project->target_amount) }}</span>
                            </div>
                            <div class="w-full bg-rahma-green-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-rahma-gold-gradient h-2.5 rounded-full relative" style="width: {{ $project->progress_percentage }}%">
                                    <div class="absolute top-0 right-0 bottom-0 left-0 bg-[linear-gradient(45deg,rgba(255,255,255,.2)_25%,transparent_25%,transparent_50%,rgba(255,255,255,.2)_50%,rgba(255,255,255,.2)_75%,transparent_75%,transparent)] bg-[length:1rem_1rem] animate-[progress_1s_linear_infinite]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('projects.show', $project->id) }}" class="block text-center py-4 bg-gray-50 text-rahma-green-800 font-bold group-hover:bg-rahma-green-900 group-hover:text-white transition-colors">
                        {{ app()->getLocale()==='en' ? 'Donate to this project' : 'تبرع لهذا المشروع' }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CTA / MARKETING BAND ============ --}}
<section class="max-w-7xl mx-auto px-4 py-28">
    <div class="relative bg-rahma-gradient rounded-[3rem] overflow-hidden px-8 py-20 text-center text-white shadow-2xl">
        <div class="absolute inset-0 dotted-pattern opacity-40"></div>
        
        {{-- Decorative Floating Elements --}}
        <div class="absolute top-10 left-10 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-rahma-gold-400/20 rounded-full blur-2xl"></div>
        <i data-lucide="droplets" class="absolute top-12 left-16 text-rahma-sky-400/50 text-5xl"></i>
        <i data-lucide="heart" class="absolute bottom-16 right-20 text-rahma-gold-400/50 text-4xl transform rotate-12"></i>

        <div class="relative z-10 max-w-3xl mx-auto">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6">{{ $org->marketing_message ?? '' }}</h2>
            <p class="text-rahma-green-50/90 text-lg md:text-xl mb-10">{{ Str::limit($org->mission ?? '', 150) }}</p>
            <a href="{{ route('donate') }}" class="inline-flex items-center gap-3 bg-rahma-gold-gradient font-black text-rahma-green-900 px-12 py-5 rounded-full shadow-[0_0_20px_rgba(252,211,77,0.4)] hover:shadow-[0_0_40px_rgba(252,211,77,0.6)] hover:scale-105 transition-all duration-300">
                <i data-lucide="hand-heart" class="w-6 h-6"></i> {{ app()->getLocale()==='en' ? 'Support a Project Today' : 'ادعم مشروعاً اليوم' }}
            </a>
        </div>
    </div>
</section>

{{-- ============ NEWS ============ --}}
@if($latestNews->count())
<section class="max-w-7xl mx-auto px-4 pb-28">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
        <div>
            <span class="text-rahma-gold-600 font-bold text-sm uppercase tracking-wider">{{ app()->getLocale()==='en' ? 'Stay Informed' : 'ابق على اطلاع' }}</span>
            <h2 class="text-3xl md:text-5xl font-black text-rahma-green-900 mt-2">{{ app()->getLocale()==='en' ? 'Latest News' : 'آخر الأخبار' }}</h2>
        </div>
        <a href="{{ route('news') }}" class="inline-flex items-center gap-2 font-bold text-rahma-green-700 bg-gray-50 px-6 py-3 rounded-full hover:bg-gray-100 hover:text-rahma-green-900 hover:-translate-y-1 transition-all">
            {{ app()->getLocale()==='en' ? 'View All News' : 'عرض كل الأخبار' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach($latestNews as $article)
            <a href="{{ route('news.show', $article->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col">
                <div class="h-60 overflow-hidden relative">
                    <img src="{{ $article->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 {{ app()->getLocale()==='ar' ? 'right-4' : 'left-4' }} bg-white/90 backdrop-blur-sm text-rahma-green-900 text-xs font-bold px-4 py-2 rounded-xl shadow-sm">
                        {{ optional($article->published_at)->format('d M Y') }}
                    </div>
                </div>
                <div class="p-8 flex-grow">
                    <h3 class="font-bold text-xl text-rahma-green-900 mb-3 group-hover:text-rahma-gold-600 transition-colors line-clamp-2">{{ $article->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-3">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}</p>
                </div>
                <div class="px-8 pb-8 flex items-center text-rahma-gold-600 font-bold text-sm gap-2 group-hover:translate-x-2 transition-transform">
                    {{ app()->getLocale()==='en' ? 'Read Article' : 'اقرأ المقال' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}" class="w-4 h-4"></i>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ============ PARTNERS (Animated Marquee) ============ --}}
@if($partners->count())
<section class="bg-gray-50 py-16 border-y border-gray-200 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 text-center mb-8 relative z-10">
        <h3 class="text-rahma-green-800/60 font-bold text-sm uppercase tracking-widest">{{ app()->getLocale()==='en' ? 'Trusted by our amazing partners' : 'شركاء النجاح الموثوقين' }}</h3>
    </div>
    
    {{-- Marquee Container --}}
    <div class="flex overflow-hidden w-full relative">
        <div class="absolute top-0 left-0 w-32 h-full bg-gradient-to-r from-gray-50 to-transparent z-10"></div>
        <div class="absolute top-0 right-0 w-32 h-full bg-gradient-to-l from-gray-50 to-transparent z-10"></div>
        
        {{-- Inner Track (Doubled for infinite scroll effect) --}}
        <div class="flex gap-8 whitespace-nowrap animate-marquee px-4 items-center">
            @foreach($partners as $partner)
                <div class="inline-flex items-center justify-center min-w-[200px] h-16 bg-white border border-gray-100 rounded-2xl shadow-sm px-6 text-rahma-green-700 font-black text-lg grayscale opacity-70 hover:grayscale-0 hover:opacity-100 hover:shadow-md transition-all duration-300">
                    {{ $partner->name }}
                </div>
            @endforeach
            {{-- Duplicate for smooth looping --}}
            @foreach($partners as $partner)
                <div class="inline-flex items-center justify-center min-w-[200px] h-16 bg-white border border-gray-100 rounded-2xl shadow-sm px-6 text-rahma-green-700 font-black text-lg grayscale opacity-70 hover:grayscale-0 hover:opacity-100 hover:shadow-md transition-all duration-300">
                    {{ $partner->name }}
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.heroSwiper', {
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                effect: 'fade', /* Fade effect looks more modern */
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                grabCursor: true,
            });
        });
    </script>
@endpush