@extends('layouts.app')
@section('title', $project->title)

@section('content')

<section class="relative">
    <div class="h-[420px] overflow-hidden">
        <img src="{{ $project->coverImage->url ?? 'https://images.unsplash.com/photo-1541913496-2246de0d56c4?auto=format&fit=crop&w=1600&q=80' }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-rahma-green-900 via-rahma-green-900/40 to-transparent"></div>
    </div>
    <div class="absolute bottom-0 inset-x-0">
        <div class="max-w-6xl mx-auto px-4 pb-10 text-white">
            <span class="bg-rahma-gold-500 text-xs font-bold px-3 py-1 rounded-full">{{ $project->category->name ?? '' }}</span>
            <h1 class="text-3xl lg:text-5xl font-black mt-4">{{ $project->title }}</h1>
            <p class="flex items-center gap-2 text-rahma-green-50/90 mt-3"><i data-lucide="map-pin"></i> {{ $project->location }} — {{ $project->governorate }}</p>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 py-16 grid lg:grid-cols-3 gap-10">
    <div class="lg:col-span-2 space-y-10">
        <div class="bg-white rounded-3xl p-8 shadow-soft">
            <h2 class="text-xl font-black text-rahma-green-800 mb-4">{{ app()->getLocale()==='en' ? 'About the Project' : 'عن المشروع' }}</h2>
            <p class="text-rahma-green-900/70 leading-8 whitespace-pre-line">{{ $project->full_description }}</p>
        </div>

        @if($project->media->count() > 1)
        <div>
            <h2 class="text-xl font-black text-rahma-green-800 mb-4">{{ app()->getLocale()==='en' ? 'Gallery' : 'معرض الصور' }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($project->media as $media)
                    <img src="{{ $media->url }}" class="rounded-2xl h-32 w-full object-cover hover:scale-105 transition">
                @endforeach
            </div>
        </div>
        @endif

        @if($project->updates->count())
        <div>
            <h2 class="text-xl font-black text-rahma-green-800 mb-6">{{ app()->getLocale()==='en' ? 'Project Updates' : 'تحديثات المشروع' }}</h2>
            <div class="relative border-s-2 border-rahma-green-200 ps-6 space-y-8">
                @foreach($project->updates as $update)
                    <div class="relative">
                        <span class="absolute -start-[31px] top-1 w-3 h-3 rounded-full bg-rahma-gold-500 ring-4 ring-rahma-gold-100"></span>
                        <span class="text-xs font-bold text-rahma-gold-600">{{ $update->published_date->format('d M Y') }}</span>
                        <h3 class="font-bold text-rahma-green-800 mt-1 mb-2">{{ $update->title }}</h3>
                        <p class="text-sm text-rahma-green-900/70 leading-7">{{ $update->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        <div class="bg-white rounded-3xl p-6 shadow-soft sticky top-28">
            <div class="w-full bg-rahma-green-100 rounded-full h-3 mb-3 overflow-hidden">
                <div class="bg-rahma-gold-gradient h-3 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
            </div>
            <div class="flex justify-between text-sm font-bold text-rahma-green-800 mb-1">
                <span>{{ number_format($project->raised_amount) }}</span>
                <span class="text-rahma-gold-600">{{ $project->progress_percentage }}%</span>
            </div>
            <p class="text-xs text-rahma-green-900/50 mb-6">{{ app()->getLocale()==='en' ? 'of target' : 'من إجمالي' }} {{ number_format($project->target_amount) }}</p>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-rahma-green-50 rounded-2xl p-4 text-center">
                    <div class="text-xl font-black text-rahma-green-700">{{ number_format($project->beneficiaries_count) }}</div>
                    <div class="text-xs text-rahma-green-900/60">{{ app()->getLocale()==='en' ? 'Beneficiaries' : 'مستفيد' }}</div>
                </div>
                <div class="bg-rahma-gold-50 rounded-2xl p-4 text-center">
                    <div class="text-xl font-black text-rahma-gold-700 capitalize">{{ $project->status }}</div>
                    <div class="text-xs text-rahma-green-900/60">{{ app()->getLocale()==='en' ? 'Status' : 'الحالة' }}</div>
                </div>
            </div>

            <a href="{{ route('donate') }}" class="w-full inline-flex items-center justify-center gap-2 bg-rahma-gradient text-white font-bold px-6 py-4 rounded-full shadow-soft hover:-translate-y-0.5 transition">
                <i data-lucide="heart-handshake"></i> {{ app()->getLocale()==='en' ? 'Donate to this Project' : 'تبرع لهذا المشروع' }}
            </a>
        </div>
    </div>
</section>

@if($related->count())
<section class="bg-rahma-green-50/60 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-black text-rahma-green-800 mb-8">{{ app()->getLocale()==='en' ? 'Related Projects' : 'مشاريع ذات صلة' }}</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $r)
                <a href="{{ route('projects.show', $r->id) }}" class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-2xl transition">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $r->coverImage->url ?? 'https://images.unsplash.com/photo-1541913496-2246de0d56c4?auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-rahma-green-800 line-clamp-1">{{ $r->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection