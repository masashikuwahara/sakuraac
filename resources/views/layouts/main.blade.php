<!DOCTYPE html>
<html lang="ja">
<head>
    @php
        $siteName = 'SAKURA DATA 46';
        $siteUrl = rtrim(config('app.url'), '/');

        $defaultTitle = '櫻坂46データベース | SAKURA DATA 46';
        $defaultDescription = '櫻坂46のメンバー情報・楽曲データベースならSAKURA DATA 46。プロフィール、あだ名、フォーメーション、センター回数、作曲者情報まで網羅。最新シングルや卒業情報も随時更新中。';
        $defaultOgImage = $siteUrl . '/storage/images/logo.png';

        $rawTitle = trim($__env->yieldContent('title'));
        $pageTitle = $rawTitle !== ''
            ? $rawTitle . ' | 櫻坂46データベース | SAKURA DATA 46'
            : $defaultTitle;

        $metaDescription = trim($__env->yieldContent('meta_description', $defaultDescription));
        $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
        $robots = trim($__env->yieldContent('robots', 'index,follow'));

        $ogTitle = trim($__env->yieldContent('og_title', $pageTitle));
        $ogDescription = trim($__env->yieldContent('og_description', $metaDescription));
        $ogType = trim($__env->yieldContent('og_type', 'website'));
        $ogUrl = trim($__env->yieldContent('og_url', $canonicalUrl));
        $ogImage = trim($__env->yieldContent('og_image', $defaultOgImage));
        $ogImageWidth = trim($__env->yieldContent('og_image_width', '1200'));
        $ogImageHeight = trim($__env->yieldContent('og_image_height', '630'));
        $ogImageAlt = trim($__env->yieldContent('og_image_alt', 'SAKURA DATA 46'));

        $twitterCard = trim($__env->yieldContent('twitter_card', 'summary_large_image'));
        $twitterTitle = trim($__env->yieldContent('twitter_title', $ogTitle));
        $twitterDescription = trim($__env->yieldContent('twitter_description', $ogDescription));
        $twitterImage = trim($__env->yieldContent('twitter_image', $ogImage));
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pageTitle }}</title>

    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="format-detection" content="email=no,telephone=no,address=no">
    <meta name="google-site-verification" content="SxBAt6QUXlWksGeFxoO9Yg4dtp-_i99Yqm_jGKOIN8Y">
    <meta name="theme-color" content="#fffcfd">

    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- OGP --}}
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:secure_url" content="{{ $ogImage }}">
    <meta property="og:image:width" content="{{ $ogImageWidth }}">
    <meta property="og:image:height" content="{{ $ogImageHeight }}">
    <meta property="og:image:alt" content="{{ $ogImageAlt }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage }}">

    {{-- 必要なら後でfaviconを追加 --}}
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}"> --}}
    {{-- <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"> --}}

    @vite('resources/css/app.css')

    {{-- 共通構造化データ --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "{{ $siteName }}",
      "url": "{{ $siteUrl }}/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ $siteUrl }}/search?q={query}"
        },
        "query-input": "required name=query"
      }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .text-shadow {
            text-shadow:
                -1px -1px 0 #fff,
                 1px -1px 0 #fff,
                -1px  1px 0 #fff,
                 1px  1px 0 #fff;
        }

        #back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            color: #fff;
            border: none;
            width: 50px;
            height: 50px;
            background-color: #f87171;
            clip-path: polygon(0% 100%, 100% 100%, 100% 0%);
            padding: 25px 25px 5px 25px;
            font-size: 10px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease, visibility 0s linear 0.8s;
        }

        #back-to-top:hover {
            background-color: #ef4444;
        }

        #back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity 0.8s ease, transform 0.8s ease, visibility 0s;
        }
    </style>

    @stack('head_meta')
</head>
<body class="bg-[#fffcfd] text-gray-800">

    @include('partials.header')

    <main class="container mx-auto">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>