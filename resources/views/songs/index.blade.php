@extends('layouts.main')

@section('title', '櫻坂46楽曲一覧')
@section('meta_description', '櫻坂46の楽曲一覧ページです。表題曲、アルバム収録曲、c/w・その他の楽曲を掲載し、発売日、センター、参加メンバー、作詞作曲情報の個別ページへリンクしています。')

@php
    $hasPage = (int) request('page') > 1;
    $canonicalUrl = $hasPage ? request()->fullUrl() : route('songs.index');
    $siteUrl = rtrim(config('app.url'), '/');

    $list = collect($singles)
        ->concat($albums)
        ->concat($others)
        ->values();
@endphp

@section('canonical', $canonicalUrl)
@section('robots', 'index,follow')
@section('og_title', '櫻坂46楽曲一覧 | SAKURA DATA 46')
@section('og_description', '櫻坂46の表題曲、アルバム収録曲、c/w・その他の楽曲を一覧で掲載。各楽曲の詳細ページへリンクしています。')
@section('og_type', 'website')
@section('og_url', $canonicalUrl)
@section('og_image', $siteUrl . '/storage/images/logo.png')
@section('og_image_alt', '櫻坂46楽曲一覧 | SAKURA DATA 46')

@push('head_meta')
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"CollectionPage",
      "name":"櫻坂46楽曲一覧 | SAKURA DATA 46",
      "url":"{{ $canonicalUrl }}",
      "description":"櫻坂46の表題曲、アルバム収録曲、c/w・その他の楽曲を一覧で掲載しています。",
      "isPartOf":{
        "@type":"WebSite",
        "name":"SAKURA DATA 46",
        "url":"{{ $siteUrl }}/"
      },
      "mainEntity":{
        "@type":"ItemList",
        "itemListElement":[
          @foreach($list as $song)
            {
              "@type":"ListItem",
              "position": {{ $loop->iteration }},
              "url": "{{ route('songs.show', $song->id) }}",
              "name": @json($song->title)
            }@if(!$loop->last),@endif
          @endforeach
        ]
      }
    }
    </script>

    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"BreadcrumbList",
      "itemListElement":[
        {
          "@type":"ListItem",
          "position":1,
          "name":"ホーム",
          "item":"{{ route('home') }}"
        },
        {
          "@type":"ListItem",
          "position":2,
          "name":"楽曲一覧",
          "item":"{{ route('songs.index') }}"
        }
      ]
    }
    </script>
@endpush

@section('content')
    <nav class="text-sm text-gray-600 mt-2 px-4" aria-label="パンくず">
        <ol class="flex space-x-2">
            <li><a href="{{ route('home') }}" class="hover:underline">ホーム</a></li>
            <li>›</li>
            <li aria-current="page">楽曲一覧</li>
        </ol>
    </nav>

    <div class="container mx-auto mt-8 px-4">
        <header>
            <h1 class="text-2xl font-semibold">楽曲一覧</h1>
            <p class="mt-2 text-sm text-gray-600">
                櫻坂46の表題曲、アルバム収録曲、c/w・その他の楽曲を一覧で掲載しています。各楽曲ページではセンター、参加メンバー、作詞作曲情報などを確認できます。
            </p>
        </header>

        <section class="mt-6" aria-labelledby="singles-heading">
            <h2 id="singles-heading" class="text-xl font-bold text-gray-800">表題曲</h2>

            @if ($singles->isEmpty())
                <p class="mt-2 text-gray-700">表題曲はまだありません。</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-2">
                    @foreach ($singles as $song)
                        <article class="text-left">
                            <a href="{{ route('songs.show', $song->id) }}" class="block group">
                                <div class="overflow-hidden">
                                    <img
                                        src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                                        alt="{{ $song->title }}（櫻坂46）"
                                        class="w-full aspect-[4/4] object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </div>

                                <p class="mt-3 text-sm sm:text-base font-medium leading-tight">
                                    {{ $song->title }}
                                    @if ($song->is_recently_updated)
                                        <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                    @endif
                                </p>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="mt-8" aria-labelledby="albums-heading">
            <h2 id="albums-heading" class="text-xl font-bold text-gray-800">アルバム収録曲</h2>

            @if ($albums->isEmpty())
                <p class="mt-2 text-gray-700">アルバム収録曲はまだありません。</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-2">
                    @foreach ($albums as $song)
                        <article class="text-left">
                            <a href="{{ route('songs.show', $song->id) }}" class="block group">
                                <div class="overflow-hidden">
                                    <img
                                        src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                                        alt="{{ $song->title }}（櫻坂46）"
                                        class="w-full aspect-[4/4] object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </div>

                                <p class="mt-3 text-sm sm:text-base font-medium leading-tight">
                                    {{ $song->title }}
                                    @if ($song->is_recently_updated)
                                        <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                    @endif
                                </p>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="mt-8" aria-labelledby="others-heading">
            <h2 id="others-heading" class="text-xl font-bold text-gray-800">c/w・その他</h2>

            @if ($others->isEmpty())
                <p class="mt-2 text-gray-700">c/wやその他の楽曲はまだありません。</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-2">
                    @foreach ($others as $song)
                        <article class="text-left">
                            <a href="{{ route('songs.show', $song->id) }}" class="block group">
                                <div class="overflow-hidden">
                                    <img
                                        src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                                        alt="{{ $song->title }}（櫻坂46）"
                                        class="w-full aspect-[4/4] object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </div>

                                <p class="mt-3 text-sm sm:text-base font-medium leading-tight">
                                    {{ $song->title }}
                                    @if ($song->is_recently_updated)
                                        <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                    @endif
                                </p>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <button id="back-to-top" title="トップへ戻る">TOP</button>

    <script>
        const button = document.getElementById("back-to-top");

        window.addEventListener("scroll", function () {
            if (window.pageYOffset > 300) {
                button.classList.add("show");
            } else {
                button.classList.remove("show");
            }
        });

        button.addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
@endsection