@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $defaultMetaTitle = \App\Models\Setting::get('default_meta_title', $siteName, 'seo');
    $defaultMetaDescription = \App\Models\Setting::get('default_meta_description', '', 'seo');
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#dc2626">

<title>{{ $title ?? ($pageTitle ?? $defaultMetaTitle) }}</title>
<meta name="description" content="{{ $metaDescription ?? $defaultMetaDescription }}">

{{-- Favicons --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

@isset($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endisset

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('head')
