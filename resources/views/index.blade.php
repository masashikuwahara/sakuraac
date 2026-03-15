@extends('layouts.main')

@section('title', '櫻坂46データベース | メンバー・楽曲情報 | SAKURA DATA 46')
@section('meta_description', '櫻坂46のメンバー情報・楽曲データベースならSAKURA DATA 46。プロフィール、あだ名、生年月日、身長、フォーメーション、センター回数、作詞作曲者情報まで網羅。最新シングルや卒業メンバー情報も随時更新中。')
@section('canonical', config('app.url') . '/')
@section('og_title', '櫻坂46データベース | SAKURA DATA 46')
@section('og_description', '櫻坂46のメンバー情報・楽曲データベース。プロフィール、あだ名、フォーメーション、センター回数、作詞作曲者情報までわかりやすく掲載。')
@section('og_type', 'website')
@section('og_url', config('app.url') . '/')
@section('og_image', config('app.url') . '/storage/images/logo.png')
@section('og_image_alt', 'SAKURA DATA 46 トップページ')

@push('head_meta')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "name": "櫻坂46データベース | SAKURA DATA 46",
      "url": "{{ rtrim(config('app.url'), '/') }}/",
      "description": "櫻坂46のメンバー情報・楽曲データベースならSAKURA DATA 46。プロフィール、あだ名、生年月日、身長、フォーメーション、センター回数、作詞作曲者情報まで網羅。",
      "inLanguage": "ja",
      "isPartOf": {
        "@type": "WebSite",
        "name": "SAKURA DATA 46",
        "url": "{{ rtrim(config('app.url'), '/') }}/"
      },
      "about": {
        "@type": "MusicGroup",
        "name": "櫻坂46"
      }
    }
    </script>
@endpush

@section('content')
    <section class="text-center mt-8 px-4">
        <h1 class="text-2xl font-bold mb-2">櫻坂46データベース SAKURA DATA 46</h1>
        <p class="text-base leading-relaxed">
            櫻坂46データベース「SAKURA DATA 46」では、メンバーのプロフィールやあだ名、生年月日、血液型、身長などの詳細情報に加え、<br>
            楽曲データ（シングル・アルバム・参加メンバー・センター回数・作詞作曲者）をわかりやすく整理しています。<br>
            最新のシングル情報や卒業メンバーのデータも日々更新中です。
        </p>
    </section>

    @php $cols = $birthdayMembers->count() === 1 ? 'grid-cols-1' : 'grid-cols-2'; @endphp
    @if(isset($birthdayMembers) && $birthdayMembers->count())
        <section class="mt-10 px-6" aria-labelledby="birthday-members-heading">
            <h2 id="birthday-members-heading" class="text-xl font-bold mb-4 flex items-center justify-center gap-2">
                <span>🎂 本日お誕生日</span>
                <span class="text-sm text-gray-500 font-normal">
                    （{{ now()->format('n月j日') }}）
                </span>
            </h2>

            <div class="flex justify-center">
                <div class="grid {{ $cols }} md:grid-cols-4 gap-6 mt-2 w-fit">
                @foreach($birthdayMembers as $m)
                    <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                        <a href="{{ route('members.show', $m->id) }}">
                            <img
                                src="{{ asset('storage/' . $m->image) }}"
                                alt="{{ $m->name }}"
                                class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto"
                                loading="lazy"
                                width="128"
                                height="128"
                            >
                            <span class="mt-2 font-semibold block">
                                {{ $m->name }}
                                <span class="text-[#f19db5] font-bold">BIRTHDAY!</span>
                            </span>

                            @if($m->birthday)
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($m->birthday)->age }}歳
                                </p>
                            @endif
                        </a>
                    </div>
                @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mt-6 text-center px-4" aria-labelledby="site-search-heading">
        <h2 id="site-search-heading" class="sr-only">サイト内検索</h2>

        @if ($errors->has('query'))
            <div class="text-red-600 font-semibold mb-2">{{ $errors->first('query') }}</div>
        @endif

        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 shadow-md" role="search">
            <input
                type="text"
                name="query"
                value="{{ old('query', request('query')) }}"
                placeholder="森田ひかる ほのす BAN"
                class="border p-2 focus:outline-none focus:ring focus:ring-[#f19db5] w-72 md:w-96 lg:w-[500px]"
                aria-label="サイト内検索キーワード"
            >

            <div class="mt-2 flex justify-center" style="--acc:#e91e63;">
                @php $cat = old('category', request('category', 'members')); @endphp

                <fieldset class="inline-flex bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden" role="radiogroup" aria-label="検索カテゴリ">
                    <label class="relative border-l border-gray-200">
                        <input
                            type="radio"
                            name="category"
                            value="members"
                            class="peer sr-only"
                            {{ $cat === 'members' ? 'checked' : '' }}
                        >
                        <span
                            class="block px-4 py-2 text-sm cursor-pointer select-none
                                text-gray-700 transition
                                hover:bg-gray-50
                                peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                                peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                        >
                            メンバー
                        </span>
                    </label>

                    <label class="relative border-l border-gray-200">
                        <input
                            type="radio"
                            name="category"
                            value="songs"
                            class="peer sr-only"
                            {{ $cat === 'songs' ? 'checked' : '' }}
                        >
                        <span
                            class="block px-4 py-2 text-sm cursor-pointer select-none
                                text-gray-700 transition
                                hover:bg-gray-50
                                peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                                peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                        >
                            楽曲
                        </span>
                    </label>
                </fieldset>
            </div>

            <button type="submit" class="mt-3 bg-[#f19db5] text-white px-4 py-2 hover:bg-[#e488a6]">
                検索
            </button>
        </form>
    </section>

    <section class="mt-10 px-6" aria-labelledby="members-heading">
        <div class="flex items-end justify-between gap-4 mb-4">
            <h2 id="members-heading" class="text-xl font-bold">メンバー</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-2">
            @foreach ($members as $member)
                <article class="text-left">
                    <a href="{{ route('members.show', $member->id) }}" class="block group">
                        <div class="overflow-hidden">
                            <img
                                src="{{ asset('storage/' . $member->image) }}"
                                alt="{{ $member->name }}"
                                class="w-full aspect-[4/5] object-cover transition-transform duration-300 group-hover:scale-105"
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
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $member->furigana }}
                            </p>
                        @endisset
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    <div class="flex items-center justify-center mt-5">
        <a href="{{ route('members.index') }}"
           class="bg-[#f19db5] text-white text-lg font-semibold py-3 px-6 hover:bg-[#e488a6] transition-transform hover:scale-105">
            メンバー一覧をすべて見る
        </a>
    </div>

    <section class="mt-10 px-6" aria-labelledby="songs-heading">
        <div class="flex items-end justify-between gap-4 mb-4">
            <h2 id="songs-heading" class="text-xl font-bold">楽曲</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 mt-2">
            @foreach ($songs as $song)
                <article class="text-left">
                    <a href="{{ route('songs.show', $song->id) }}" class="block group">
                        <div class="overflow-hidden">
                            <img
                                src="{{ asset('storage/photos/' . $song->photo) }}"
                                alt="{{ $song->title }}"
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
    </section>

    <div class="flex items-center justify-center mt-5">
        <a href="{{ route('songs.index') }}"
           class="bg-[#f19db5] text-white text-lg font-semibold py-3 px-6 hover:bg-[#e488a6] transition-transform hover:scale-105">
            楽曲一覧をすべて見る
        </a>
    </div>

    <section class="mt-10 px-6" aria-labelledby="recently-viewed-heading">
        <div class="flex items-center justify-between mb-4">
            <h2 id="recently-viewed-heading" class="text-xl font-bold">最近見たページ</h2>
            <button
                id="clearRecent"
                class="bg-[#f19db5] text-white text-xs font-semibold py-2 px-4 hover:bg-[#e488a6] transition-transform"
            >
                履歴をクリア
            </button>
        </div>
        <div id="recently-viewed" class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2"></div>
    </section>

    <section class="mt-8 px-6" aria-labelledby="update-logs-heading">
        <div class="text-center mb-2">
            <h2 id="update-logs-heading" class="text-sm">更新履歴</h2>
        </div>

        <div class="mx-auto w-4/5 max-h-60 overflow-y-scroll bg-white p-4 shadow-md">
            <div class="text-left inline-block w-full">
                @forelse ($logs as $log)
                    <p class="text-sm leading-6">
                        <span class="tabular-nums">{{ $log->date->format('Y.m.d') }}</span>
                        @if($log->version)
                            &nbsp;<span class="font-mono">v.{{ ltrim($log->version, 'v.') }}</span>
                        @endif
                        &nbsp;{!! $log->is_new ? '<span class="text-red-600 font-bold">NEW!</span>&nbsp;' : '' !!}
                        @if($log->link)
                            <a href="{{ $log->link }}" target="_blank" rel="noopener" class="hover:underline">{{ $log->title }}</a>
                        @else
                            {{ $log->title }}
                        @endif
                    </p>
                @empty
                    <p class="text-sm text-gray-500">まだ更新履歴はありません。</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        (() => {
            const KEY = 'recentlyViewed';
            const container = document.getElementById('recently-viewed');
            if (!container) return;

            const toItemUrl = (item) => {
                let url = item?.url || '';

                if (!url) return '/';
                try {
                    if (/^https?:\/\//i.test(url)) url = new URL(url).pathname;
                } catch (_) {}

                const type = String(item?.type || '').toLowerCase();

                if (type === 'song') {
                    url = url.replace(/^\/members\//, '/songs/');
                } else if (type === 'member') {
                    url = url.replace(/^\/songs\//, '/members/');
                }

                return new URL(url, window.location.origin).toString();
            };

            const toImageUrl = (item) => {
                let src = item?.image || '';
                if (!src) return '';

                src = String(src).replace(/\\/g, '/');

                const isMember = String(item?.type || '').toLowerCase() === 'member';

                const getFileName = (s) => {
                    try {
                        if (/^https?:\/\//i.test(s)) s = new URL(s).pathname;
                    } catch (_) {}
                    return (s.split('/').pop() || '').trim();
                };

                const fname = getFileName(src);
                if (!fname) return '';

                return isMember ? `/storage/images/${fname}` : `/storage/photos/${fname}`;
            };

            const raw = localStorage.getItem(KEY);
            const list = raw ? JSON.parse(raw) : [];

            if (!list.length) {
                container.innerHTML = '<p class="text-gray-600">まだ履歴はありません。</p>';
                return;
            }

            const normalized = list.map(it => ({ ...it, image: toImageUrl(it) }));
            localStorage.setItem(KEY, JSON.stringify(normalized));

            container.innerHTML = normalized.map(item => {
                const img = item.image;
                return `
                <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                    <a href="${toItemUrl(item)}">
                        ${img ? `<img src="${img}" alt="${item.title}" width="128" height="128" loading="lazy" class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto">` : ''}
                        <p class="mt-2 font-semibold">${item.title}</p>
                        <p class="text-xs text-gray-500">${item.type === 'member' ? 'メンバー' : '楽曲'}</p>
                    </a>
                </div>
                `;
            }).join('');

            const clearBtn = document.getElementById('clearRecent');
            clearBtn?.addEventListener('click', () => {
                localStorage.removeItem(KEY);
                container.innerHTML = '<p class="text-gray-600">履歴をクリアしました。</p>';
            });
        })();
    </script>
    <!-- v.2.6.3 -->
@endsection