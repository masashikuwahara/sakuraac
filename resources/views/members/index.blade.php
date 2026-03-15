@extends('layouts.main')

@section('title', '櫻坂46メンバー一覧')
@section('meta_description', '櫻坂46のメンバー一覧ページです。在籍・卒業メンバーを期別に確認できるほか、50音順、血液型順、誕生日順、身長順、参加楽曲順、表題曲参加順、センター回数順でも見られます。')

@php
    $hasSort = request()->has('sort') || request()->has('order');
    $hasPage = (int) request('page') > 1;

    $canonicalUrl = $hasSort
        ? route('members.index')
        : ($hasPage ? request()->fullUrl() : route('members.index'));

    $siteUrl = rtrim(config('app.url'), '/');

    $labels = [
        'default'    => 'デフォルト',
        'furigana'   => '50音順',
        'blood'      => '血液型順',
        'birth'      => '誕生日順',
        'height'     => '身長順',
        'songs'      => '参加楽曲順',
        'titlesongs' => '表題曲参加順',
        'center'     => 'センター回数順',
    ];
@endphp

@section('canonical', $canonicalUrl)
@section('robots', $hasSort ? 'noindex,follow' : 'index,follow')
@section('og_title', '櫻坂46メンバー一覧 | SAKURA DATA 46')
@section('og_description', '櫻坂46の在籍・卒業メンバー一覧。期別表示や50音順、誕生日順、身長順などの並び替えに対応。')
@section('og_type', 'website')
@section('og_url', $canonicalUrl)
@section('og_image', $siteUrl . '/storage/images/logo.png')
@section('og_image_alt', '櫻坂46メンバー一覧 | SAKURA DATA 46')

@push('head_meta')
    @php
        $currentData = $sort === 'default'
            ? collect($currentMembers)->flatten(1)
            : (method_exists($currentMembers, 'items')
                ? collect($currentMembers->items())
                : collect($currentMembers));

        $graduatedData = $sort === 'default'
            ? collect($graduatedMembers)->flatten(1)
            : (method_exists($graduatedMembers, 'items')
                ? collect($graduatedMembers->items())
                : collect($graduatedMembers));

        $list = $currentData->merge($graduatedData)->values();
    @endphp

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      "name": "櫻坂46メンバー一覧 | SAKURA DATA 46",
      "url": "{{ $canonicalUrl }}",
      "description": "櫻坂46の在籍・卒業メンバーを一覧で掲載。プロフィールや各種データページへの導線もまとめています。",
      "isPartOf": {
        "@type": "WebSite",
        "name": "SAKURA DATA 46",
        "url": "{{ $siteUrl }}/"
      }@if(!$hasSort && $list->isNotEmpty()),
      "mainEntity": {
        "@type": "ItemList",
        "itemListElement": [
          @foreach($list as $m)
          {
            "@type": "ListItem",
            "position": {{ $loop->iteration }},
            "url": "{{ route('members.show', $m->id) }}",
            "name": @json($m->name)
          }@if(!$loop->last),@endif
          @endforeach
        ]
      }@endif
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
          "name":"メンバー一覧",
          "item":"{{ route('members.index') }}"
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
            <li aria-current="page">メンバー一覧</li>
        </ol>
    </nav>

    <main class="container mx-auto mt-8 px-4">
        <header>
            <h1 class="text-2xl font-semibold">櫻坂46メンバー一覧</h1>
            <p class="mt-2 text-sm text-gray-600">
                櫻坂46の在籍・卒業メンバーを一覧で掲載しています。期別表示に加えて、50音順・血液型順・誕生日順・身長順・参加楽曲順・表題曲参加順・センター回数順で並び替えできます。
            </p>
            <p class="mt-2 text-sm">現在のソート: {{ $labels[$sort] ?? 'デフォルト' }}</p>
        </header>

        <div x-data="{ open:false }" x-cloak class="relative md:static">
            <div class="hidden md:flex justify-center flex-wrap gap-4 mt-4">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    デフォルトに戻す
                </a>
                <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    50音順
                </a>
                <a href="{{ route('members.index', ['sort' => 'blood', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    血液型順
                </a>
                <a href="{{ route('members.index', ['sort' => 'birth', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    誕生日順
                </a>
                <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    身長順
                </a>
                <a href="{{ route('members.index', ['sort' => 'songs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    参加楽曲順
                </a>
                <a href="{{ route('members.index', ['sort' => 'titlesongs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    表題曲参加順
                </a>
                <a href="{{ route('members.index', ['sort' => 'center', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    センター回数順
                </a>
            </div>

            <div class="md:hidden mt-4" x-data="{ open:false }">
                <button @click="open=!open" class="w-full flex items-center justify-between bg-[#f19db5] text-white px-4 py-3">
                    <span class="text-sm font-medium">ソートメニュー</span>
                    <svg class="h-5 w-5 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div
                    x-ref="panel"
                    x-bind:style="open ? 'max-height:' + $refs.panel.scrollHeight + 'px' : 'max-height:0px'"
                    class="overflow-hidden transition-all duration-300 mt-2 shadow-lg bg-[#f19db5]"
                >
                    <div class="py-1">
                        <a href="{{ route('members.index') }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">デフォルトに戻す</a>
                        <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">50音順</a>
                        <a href="{{ route('members.index', ['sort' => 'blood', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">血液型順</a>
                        <a href="{{ route('members.index', ['sort' => 'birth', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">誕生日順</a>
                        <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">身長順</a>
                        <a href="{{ route('members.index', ['sort' => 'songs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">参加楽曲順</a>
                        <a href="{{ route('members.index', ['sort' => 'titlesongs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">表題曲参加順</a>
                        <a href="{{ route('members.index', ['sort' => 'center', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e488a6]">センター回数順</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">ボタンを繰り返し押すと昇順・降順を切り替えできます。</p>
        </div>

        @if ($sort === 'default')
            <section class="mt-6" aria-labelledby="current-members-heading">
                <h2 id="current-members-heading" class="text-xl font-bold text-gray-800">在籍メンバー</h2>

                @if (is_array($currentMembers) || is_object($currentMembers))
                    @if (empty((array)$currentMembers))
                        <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                    @else
                        @foreach ($currentMembers as $grade => $members)
                            <section class="mt-4" aria-labelledby="grade-{{ \Illuminate\Support\Str::slug($grade) }}">
                                <h3 id="grade-{{ \Illuminate\Support\Str::slug($grade) }}" class="text-lg font-semibold">{{ $grade }}</h3>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-4">
                                    @foreach ($members as $member)
                                        <article class="text-left">
                                            <a href="{{ route('members.show', $member->id) }}" class="block group">
                                                <div class="overflow-hidden">
                                                    <img
                                                        src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                        alt="{{ $member->name }}（櫻坂46）"
                                                        class="w-full aspect-[1/1.25] max-w-[480px] object-cover transition-transform duration-300 group-hover:scale-105"
                                                        loading="lazy"
                                                    >
                                                </div>

                                                <p class="mt-2 text-sm sm:text-base font-medium leading-tight">
                                                    {{ $member->name }}
                                                    @if ($member->is_recently_updated)
                                                        <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                                    @endif
                                                </p>

                                                @isset($member->furigana)
                                                    <p class="text-xs text-gray-500 mt-1">{{ $member->furigana }}</p>
                                                @endisset
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    @endif
                @endif
            </section>

            <section class="mt-8" aria-labelledby="graduated-members-heading">
                <h2 id="graduated-members-heading" class="text-xl font-bold text-gray-800">卒業メンバー</h2>

                @if (is_array($graduatedMembers) || is_object($graduatedMembers))
                    @if (empty((array)$graduatedMembers))
                        <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                    @else
                        @foreach ($graduatedMembers as $grade => $members)
                            <section class="mt-4" aria-labelledby="graduated-grade-{{ \Illuminate\Support\Str::slug($grade) }}">
                                <h3 id="graduated-grade-{{ \Illuminate\Support\Str::slug($grade) }}" class="text-lg font-semibold">{{ $grade }}</h3>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-4">
                                    @foreach ($members as $member)
                                        <article class="text-left">
                                            <a href="{{ route('members.show', $member->id) }}" class="block group">
                                                <div class="overflow-hidden">
                                                    <img
                                                        src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                        alt="{{ $member->name }}（櫻坂46）"
                                                        class="w-full aspect-[1/1.25] max-w-[480px] object-cover transition-transform duration-300 group-hover:scale-105"
                                                        loading="lazy"
                                                    >
                                                </div>

                                                <p class="mt-2 text-sm sm:text-base font-medium leading-tight">
                                                    {{ $member->name }}
                                                    @if ($member->is_recently_updated)
                                                        <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                                    @endif
                                                </p>

                                                @isset($member->furigana)
                                                    <p class="text-xs text-gray-500 mt-1">{{ $member->furigana }}</p>
                                                @endisset
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    @endif
                @endif
            </section>
        @else
            <section class="mt-6" aria-labelledby="sorted-current-members-heading">
                <h2 id="sorted-current-members-heading" class="text-xl font-bold text-gray-800">在籍メンバー</h2>

                @if ($currentMembers->isEmpty())
                    <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-4">
                        @foreach ($currentMembers as $member)
                            <article class="text-left">
                                <a href="{{ route('members.show', $member->id) }}" class="block group">
                                    <div class="overflow-hidden">
                                        <img
                                            src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                            alt="{{ $member->name }}（櫻坂46）"
                                            class="w-full aspect-[1/1.25] max-w-[480px] object-cover transition-transform duration-300 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    </div>

                                    <p class="mt-2 text-sm sm:text-base font-medium leading-tight">
                                        {{ $member->name }}
                                        @if ($member->is_recently_updated)
                                            <span class="ml-1 text-red-600 font-bold text-xs align-middle">NEW!</span>
                                        @endif
                                    </p>

                                    @if (isset($member->additional_info))
                                        <p class="text-xs text-gray-500 mt-1">{{ $member->additional_info }}</p>
                                    @endif
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="mt-8" aria-labelledby="sorted-graduated-members-heading">
                <h2 id="sorted-graduated-members-heading" class="text-xl font-bold text-gray-800">卒業メンバー</h2>

                @if ($graduatedMembers->isEmpty())
                    <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-4">
                        @foreach ($graduatedMembers as $member)
                            <article class="text-left">
                                <a href="{{ route('members.show', $member->id) }}" class="block group">
                                    <div class="overflow-hidden">
                                        <img
                                            src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                            alt="{{ $member->name }}（櫻坂46）"
                                            class="w-full aspect-[1/1.25] max-w-[480px] object-cover transition-transform duration-300 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    </div>

                                    <p class="mt-2 text-sm sm:text-base font-medium leading-tight">
                                        {{ $member->name }}
                                    </p>

                                    @if (isset($member->additional_info))
                                        <p class="text-xs text-gray-500 mt-1">{{ $member->additional_info }}</p>
                                    @endif
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </main>

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