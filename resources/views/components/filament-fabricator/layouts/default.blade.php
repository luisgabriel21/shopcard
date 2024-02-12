@props(['page'])
<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getlocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>


    <title>Shopcard<x-filament-fabricator::layouts.base :title="$page->title"></title>

            </style>
    

    {{-- Header Here --}}
</head>

<body>
    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />
</body>

    {{-- Header Here --}}
     {{-- Footer Here --}}
</x-filament-fabricator::layouts.base>