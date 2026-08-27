<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $org->name ?? ' مراحمين الخيرية')</title>
    <meta name="description" content="{{ \App\Models\SiteSetting::get('meta_description', '') }}">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    {{--
        IMPORTANT: never use @latest for Lucide — unpkg has repeated outages
        (503/520 errors) and breaking API changes on that tag. Pin an exact
        version. Check https://unpkg.com/lucide for the current stable release
        and bump this manually when you want to upgrade.
    --}}
    <script src="https://unpkg.com/lucide@0.462.0/dist/umd/lucide.js"></script>

    {{-- Alpine Collapse plugin MUST be loaded before Alpine core (both deferred,
         order is preserved). Without this, x-collapse below silently fails. --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    {{-- Alpine is started manually (see bottom script) so icons are converted to SVG first --}}
    <script>window.deferLoadingAlpine = function (callback) { window.__startAlpine = callback; }</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                        tajawal: ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        rahma: {
                            green: {
                                50:  '#eef9ef',
                                100: '#d7f0da',
                                200: '#aee0b5',
                                300: '#7dcb88',
                                400: '#4fb85e',
                                500: '#2e9e40', // primary logo green
                                600: '#237e32',
                                700: '#1c632a',
                                800: '#194f25',
                                900: '#154020',
                            },
                            gold: {
                                50:  '#fff8e9',
                                100: '#ffedc2',
                                200: '#ffdc8a',
                                300: '#ffc650',
                                400: '#fdb02a',
                                500: '#f39c12', // primary logo orange/gold
                                600: '#d17d09',
                                700: '#a8600b',
                                800: '#894d10',
                                900: '#734112',
                            },
                            sky: {
                                400: '#5cc9f0',
                                500: '#33b3e8', // water droplets
                            },
                            cream: '#fdfaf3',
                        }
                    },
                    boxShadow: {
                        soft: '0 10px 40px -12px rgba(46,158,64,0.25)',
                    },
                    backgroundImage: {
                        'rahma-gradient': 'linear-gradient(135deg, #2e9e40 0%, #237e32 55%, #154020 100%)',
                        'rahma-gold-gradient': 'linear-gradient(135deg, #fdb02a 0%, #f39c12 60%, #d17d09 100%)',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Cairo', sans-serif; background: #fdfaf3; }
        .arch-clip {
            clip-path: path('M0,80 C0,30 40,0 90,0 L410,0 C460,0 500,30 500,80 L500,320 L0,320 Z');
        }
        .dotted-pattern {
            background-image: radial-gradient(#2e9e40 1.2px, transparent 1.2px);
            background-size: 18px 18px;
            opacity: .08;
        }
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #eef9ef; }
        ::-webkit-scrollbar-thumb { background: #7dcb88; border-radius: 10px; }
        .fade-up { animation: fadeUp .7s ease both; }
        @keyframes fadeUp { from { opacity:0; transform: translateY(18px);} to {opacity:1; transform:translateY(0);} }
        .droplet { animation: drip 2.8s ease-in-out infinite; }
        @keyframes drip { 0%,100%{ transform: translateY(0); opacity:.9;} 50%{ transform: translateY(6px); opacity:.4;} }

        /* Lucide icons: size follows the element's font-size (text-2xl, text-sm, etc.)
           exactly like the old icon-font behaved, and color follows currentColor. */
        svg.lucide {
            width: 1em;
            height: 1em;
            stroke-width: 2;
            display: inline-block;
            vertical-align: -0.125em;
            flex-shrink: 0;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="text-rahma-green-900 antialiased">

{{-- ============ TOP BAR ============ --}}
<div class="bg-rahma-green-900 text-rahma-green-50 text-xs">
    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-center gap-4">
            @if($org->email ?? false)
                <span class="flex items-center gap-1 opacity-90"><i data-lucide="mail"></i> {{ $org->email }}</span>
            @endif
            @if($org->phone ?? false)
                <span class="flex items-center gap-1 opacity-90"><i data-lucide="phone"></i> {{ $org->phone }}</span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            @foreach($socialLinks ?? [] as $link)
                <a href="{{ $link->url }}" target="_blank" class="w-6 h-6 rounded-full bg-white/10 hover:bg-rahma-gold-500 flex items-center justify-center transition">
                    <x-social-icon :link="$link" class="w-3 h-3" />
                </a>
            @endforeach
            <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="ms-2 px-2 py-0.5 rounded-full border border-white/30 hover:bg-white hover:text-rahma-green-900 transition">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
            </a>
        </div>
    </div>
</div>

{{-- ============ NAVBAR ============ --}}
<header x-data="{ open:false, scrolled:false }" @scroll.window="scrolled = window.scrollY > 20"
        :class="scrolled ? 'shadow-soft bg-white/95' : 'bg-white'"
        class="sticky top-0 z-50 backdrop-blur transition-all duration-300 border-b border-rahma-green-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.jpg') }}" alt="{{ $org->name ?? 'logo' }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-rahma-gold-400 group-hover:ring-rahma-green-500 transition">
                <div class="leading-tight">
                    <div class="font-extrabold text-rahma-green-700 text-lg">{{ $org->name ?? ' متراحمين الخيرية' }}</div>
                    <div class="text-[11px] text-rahma-gold-600 font-semibold">{{ $org->marketing_message ?? '' }}</div>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-1 font-semibold text-sm">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label_ar' => 'الرئيسية', 'label_en' => 'Home'],
                        ['route' => 'about', 'label_ar' => 'من نحن', 'label_en' => 'About'],
                        ['route' => 'projects', 'label_ar' => 'مشاريعنا', 'label_en' => 'Projects'],
                        ['route' => 'news', 'label_ar' => 'الأخبار', 'label_en' => 'News'],
                        ['route' => 'contact', 'label_ar' => 'اتصل بنا', 'label_en' => 'Contact'],
                    ];
                @endphp
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="px-4 py-2 rounded-full transition {{ request()->routeIs($link['route']) ? 'bg-rahma-green-500 text-white' : 'text-rahma-green-800 hover:bg-rahma-green-50' }}">
                        {{ app()->getLocale() === 'en' ? $link['label_en'] : $link['label_ar'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('donate') }}" class="hidden sm:inline-flex items-center gap-2 bg-rahma-gold-gradient text-white font-bold px-5 py-2.5 rounded-full shadow-soft hover:brightness-105 hover:-translate-y-0.5 transition">
                    <i data-lucide="heart-handshake"></i>
                    {{ app()->getLocale() === 'en' ? 'Donate Now' : 'تبرع الآن' }}
                </a>
                <button @click="open = !open" class="lg:hidden w-10 h-10 rounded-full bg-rahma-green-50 flex items-center justify-center text-rahma-green-700">
                    <i x-show="!open" data-lucide="menu"></i>
                    <i x-show="open" x-cloak data-lucide="x"></i>
                </button>
            </div>
        </div>

        <div x-show="open" x-collapse class="lg:hidden pb-4 flex flex-col gap-1">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="px-4 py-2.5 rounded-xl {{ request()->routeIs($link['route']) ? 'bg-rahma-green-500 text-white' : 'bg-rahma-green-50 text-rahma-green-800' }} font-semibold">
                    {{ app()->getLocale() === 'en' ? $link['label_en'] : $link['label_ar'] }}
                </a>
            @endforeach
            <a href="{{ route('donate') }}" class="mt-2 text-center bg-rahma-gold-gradient text-white font-bold px-5 py-3 rounded-xl">
                {{ app()->getLocale() === 'en' ? 'Donate Now' : 'تبرع الآن' }}
            </a>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="bg-rahma-gradient text-white mt-24 relative overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-7xl mx-auto px-4 py-16 relative">
        <div class="grid md:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" class="w-14 h-14 rounded-full ring-2 ring-rahma-gold-400 object-cover" alt="logo">
                    <div class="font-extrabold text-xl">{{ $org->name ?? 'متراحمين الخيرية' }}</div>
                </div>
                <p class="text-sm text-rahma-green-100/90 leading-7">{{ Str::limit($org->about_text ?? '', 160) }}</p>
                <div class="flex gap-2 mt-5">
                    @foreach($socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 hover:bg-rahma-gold-500 flex items-center justify-center transition">
                            <x-social-icon :link="$link" class="w-4 h-4" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-bold text-rahma-gold-300 mb-4">{{ app()->getLocale()==='en' ? 'Quick Links' : 'روابط سريعة' }}</h4>
                <ul class="space-y-2 text-sm text-rahma-green-100/90">
                    <li><a href="{{ route('about') }}" class="hover:text-rahma-gold-300 transition">{{ app()->getLocale()==='en' ? 'About Us' : 'من نحن' }}</a></li>
                    <li><a href="{{ route('projects') }}" class="hover:text-rahma-gold-300 transition">{{ app()->getLocale()==='en' ? 'Projects' : 'مشاريعنا' }}</a></li>
                    <li><a href="{{ route('news') }}" class="hover:text-rahma-gold-300 transition">{{ app()->getLocale()==='en' ? 'News' : 'الأخبار' }}</a></li>
                    <li><a href="{{ route('donate') }}#volunteer" class="hover:text-rahma-gold-300 transition">{{ app()->getLocale()==='en' ? 'Volunteer' : 'تطوع معنا' }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-rahma-gold-300 mb-4">{{ app()->getLocale()==='en' ? 'Contact' : 'تواصل معنا' }}</h4>
                <ul class="space-y-3 text-sm text-rahma-green-100/90">
                    <li class="flex items-center gap-2"><i data-lucide="mail" class="text-rahma-gold-300"></i> {{ $org->email ?? '' }}</li>
                    <li class="flex items-center gap-2"><i data-lucide="phone" class="text-rahma-gold-300"></i> {{ $org->phone ?? '' }}</li>
                    <li class="flex items-center gap-2"><i data-lucide="map-pin" class="text-rahma-gold-300"></i> {{ $org->address ?? '' }}</li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-rahma-gold-300 mb-4">{{ app()->getLocale()==='en' ? 'Newsletter' : 'النشرة البريدية' }}</h4>
                <p class="text-sm text-rahma-green-100/90 mb-3">{{ app()->getLocale()==='en' ? 'Stay updated with our latest news' : 'كن أول من يعلم بآخر أخبارنا' }}</p>
                <form class="flex gap-2">
                    <input type="email" placeholder="{{ app()->getLocale()==='en' ? 'Your email' : 'بريدك الإلكتروني' }}" class="flex-1 min-w-0 rounded-full px-4 py-2 text-sm text-rahma-green-900 focus:outline-none focus:ring-2 focus:ring-rahma-gold-400">
                    <button type="submit" class="bg-rahma-gold-500 hover:bg-rahma-gold-600 transition rounded-full px-4 py-2 flex items-center justify-center">
                        <i data-lucide="send"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-white/15 mt-12 pt-6 text-center text-xs text-rahma-green-100/80">
            {!! \App\Models\SiteSetting::get('footer_copyright_text', '© ' . date('Y')) !!}
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Guard: if the Lucide CDN failed to load (network block, CDN outage),
        // don't let that silently kill Alpine too — log it clearly instead.
        if (typeof lucide === 'undefined') {
            console.error('[icons] Lucide failed to load from the CDN — icons will stay blank. Check the Network tab for the lucide script request.');
        } else {
            try {
                lucide.createIcons();
            } catch (e) {
                console.error('[icons] lucide.createIcons() threw an error:', e);
            }
        }

        // Always start Alpine even if icons failed, so the rest of the UI
        // (menus, dropdowns, etc.) still works.
        if (window.__startAlpine) {
            window.__startAlpine();
        } else {
            console.error('[alpine] window.__startAlpine was never set — Alpine core script may not have loaded.');
        }
    });
</script>
@stack('scripts')
</body>
</html>