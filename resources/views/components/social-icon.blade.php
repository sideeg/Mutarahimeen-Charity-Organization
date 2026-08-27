{{--
    Renders a brand/social icon (Facebook, Twitter/X, Instagram, YouTube, TikTok,
    WhatsApp, LinkedIn, Telegram, etc.) via Simple Icons.

    Lucide does NOT include brand logos, so lucide-facebook / lucide-whatsapp / etc.
    never render anything. This component pulls the correct SVG from the Simple
    Icons CDN instead, based on $link->icon_name.

    Usage:
        <x-social-icon :link="$link" class="w-4 h-4" />
--}}
@props(['link'])

@php
    // Simple Icons slugs are lowercase, no spaces. Normalize whatever is stored
    // in the DB (e.g. "Facebook", "X (Twitter)", "WhatsApp") into a usable slug.
    $slug = \Illuminate\Support\Str::slug($link->icon_name ?? '', '');
    // A couple of common aliases people tend to store instead of the real slug.
    $aliases = [
        'twitter' => 'x',
        'x' => 'x',
        'ig' => 'instagram',
        'fb' => 'facebook',
        'yt' => 'youtube',
        'wa' => 'whatsapp',
    ];
    $slug = $aliases[$slug] ?? $slug;

    // Simple Icons permanently removed LinkedIn (brand-guideline takedown,
    // simple-icons/simple-icons#11372) — it will never come back on that CDN.
    // Serve a self-hosted SVG for it instead; everything else still goes
    // through Simple Icons as normal.
    $selfHosted = [
        'linkedin' => 'icons/linkedin.svg',
    ];
@endphp

@if(isset($selfHosted[$slug]))
    <img
        src="{{ asset($selfHosted[$slug]) }}"
        alt="{{ $link->platform_name ?? $link->icon_name ?? 'social link' }}"
        loading="lazy"
        {{ $attributes->merge(['class' => 'w-4 h-4 object-contain']) }}
    >
@else
    <img
        src="https://cdn.simpleicons.org/{{ $slug }}/ffffff"
        alt="{{ $link->platform_name ?? $link->icon_name ?? 'social link' }}"
        loading="lazy"
        onerror="this.style.display='none'"
        {{ $attributes->merge(['class' => 'w-4 h-4 object-contain']) }}
    >
@endif