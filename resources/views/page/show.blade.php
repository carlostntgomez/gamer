<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->seo_title ?? $page->title }}</title>
    <meta name="description" content="{{ $page->seo_description ?? Str::limit(strip_tags($page->content), 150) }}">
    <meta name="keywords" content="{{ $page->seo_keywords ?? '' }}">
</head>
<body>
    <h1>{{ $page->title }}</h1>
    <div>
        {!! $page->content !!}
    </div>
</body>
</html>