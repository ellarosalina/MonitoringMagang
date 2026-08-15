@props([
    'title' => 'Dashboard',
    'subtitle' => null,
])

@php
    $pageTitle = $title;
    $pageSubtitle = $subtitle;
@endphp

@include('layouts.navigation', [
    'title' => $pageTitle,
    'subtitle' => $pageSubtitle,
    'slot' => $slot,
])