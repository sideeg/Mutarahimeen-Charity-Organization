@extends('layouts.app')
@section('title', ($org->name ?? '') . ' | ' . (app()->getLocale()==='en' ? 'Projects' : 'مشاريعنا'))

@section('content')

<section class="relative bg-rahma-gradient overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-5xl mx-auto px-4 py-16 text-center text-white relative">
        <h1 class="text-4xl lg:text-5xl font-black mb-4">{{ app()->getLocale()==='en' ? 'Our Projects' : 'مشاريعنا' }}</h1>
        <p class="text-rahma-green-50/90 max-w-2xl mx-auto">{{ app()->getLocale()==='en' ? 'Explore our ongoing and completed initiatives across Sudan' : 'استعرض مبادراتنا الجارية والمكتملة في مختلف ولايات السودان' }}</p>
    </div>
    <svg class="w-full text-rahma-cream" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">

    {{-- Category filter --}}
    <div class="flex flex-wrap gap-3 justify-center mb-14">
        <a href="{{ route('projects') }}" class="px-5 py-2.5 rounded-full font-bold text-sm transition {{ !$activeCategory ? 'bg-rahma-green-500 text-white' : 'bg-rahma-green-50 text-rahma-green-700 hover:bg-rahma-green-100' }}">
            {{ app()->getLocale()==='en' ? 'All' : 'الكل' }}
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('projects', ['category' => $cat->id]) }}" class="px-5 py-2.5 rounded-full font-bold text-sm transition flex items-center gap-2 {{ $activeCategory == $cat->id ? 'bg-rahma-green-500 text-white' : 'bg-rahma-green-50 text-rahma-green-700 hover:bg-rahma-green-100' }}">
                <i data-lucide="{{ $cat->icon_name ?? 'heart' }}"></i> {{ $cat->name }}
            </a>
        @endforeach
    </div>

    @if($projects->isEmpty())
        <div class="text-center py-24 text-rahma-green-500">
            <i data-lucide="search-x" class="text-5xl mb-4"></i>
            <p class="font-bold">{{ app()->getLocale()==='en' ? 'No projects found in this category.' : 'لا توجد مشاريع في هذا التصنيف حالياً.' }}</p>
        </div>
    @else
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}" class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $project->coverImage->url ?? asset('images/placeholder-project.svg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <span class="absolute top-3 {{ app()->getLocale()==='ar' ? 'right-3' : 'left-3' }} bg-rahma-gold-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $project->category->name ?? '' }}</span>
                    @if($project->status === 'completed')
                        <span class="absolute top-3 {{ app()->getLocale()==='ar' ? 'left-3' : 'right-3' }} bg-rahma-green-600 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1"><i data-lucide="check-circle"></i> {{ app()->getLocale()==='en' ? 'Completed' : 'مكتمل' }}</span>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-rahma-green-800 mb-2">{{ $project->title }}</h3>
                    <p class="text-sm text-rahma-green-900/60 mb-5 line-clamp-2">{{ $project->short_description }}</p>
                    <div class="w-full bg-rahma-green-100 rounded-full h-2.5 mb-2 overflow-hidden">
                        <div class="bg-rahma-gold-gradient h-2.5 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs font-semibold text-rahma-green-700 mb-4">
                        <span>{{ number_format($project->raised_amount) }}</span>
                        <span class="text-rahma-gold-600">{{ $project->progress_percentage }}%</span>
                    </div>
                    <span class="inline-flex items-center gap-1 text-sm font-bold text-rahma-green-600 group-hover:text-rahma-gold-600 transition">
                        {{ app()->getLocale()==='en' ? 'View Details' : 'التفاصيل' }} <i data-lucide="arrow-{{ app()->getLocale()==='ar' ? 'left' : 'right' }}"></i>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
    @endif
</section>

@endsection