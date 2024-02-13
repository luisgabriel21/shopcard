@props(['page'])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>Flyer Promocional Shopcard</title>
    <x-filament-fabricator::layouts.base :title="$page->title">
    {{-- Header Here --}}
</head>

<body>
    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />
</body>

    {{-- Header Here --}}
     {{-- Footer Here --}}
</x-filament-fabricator::layouts.base>