@extends('layouts.main')

@php
    use Illuminate\Support\Str;

    $siteUrl = rtrim(config('app.url'), '/');

    $titleCore = $song->title . '（櫻坂46）楽曲情報｜センター・参加メンバー・作詞作曲';
    $metaDescription = Str::limit(
        implode('', array_filter([
            $song->title . '（櫻坂46）の楽曲情報ページです。',
            !empty($song->release_date) ? 'リリース日は' . \Carbon\Carbon::parse($song->release_date)->format('Y年n月j日') . '。' : null,
            !empty($song->lyricist) ? '作詞は' . $song->lyricist . '。' : null,
            !empty($song->composer) ? '作曲は' . $song->composer . '。' : null,
            'センター、参加メンバー、収録作品、ミュージックビデオ情報などを掲載しています。',
        ])),
        120
    );

    $canonicalUrl = route('songs.show', $song->id);

    $songImage = !empty($song->jacket_image_url)
        ? $song->jacket_image_url
        : (!empty($song->photo)
            ? asset('storage/photos/' . ltrim($song->photo, '/'))
            : $siteUrl . '/storage/images/logo.png');

    $releaseDate = !empty($song->release_date)
        ? \Carbon\Carbon::parse($song->release_date)->format('Y年m月d日')
        : '—';

    $musicLd = [
        '@context' => 'https://schema.org',
        '@type' => 'MusicRecording',
        'name' => $song->title,
        'url' => $canonicalUrl,
        'image' => $songImage,
        'byArtist' => [
            '@type' => 'MusicGroup',
            'name' => '櫻坂46',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Sony Music Labels',
        ],
    ];

    if (!empty($song->album_title)) {
        $musicLd['inAlbum'] = [
            '@type' => 'MusicAlbum',
            'name' => $song->album_title,
        ];
    }

    if (!empty($song->release_date)) {
        $musicLd['datePublished'] = \Carbon\Carbon::parse($song->release_date)->toDateString();
    }

    if (!empty($song->genre)) {
        $musicLd['genre'] = $song->genre;
    }

    if (!empty($song->duration)) {
        $musicLd['duration'] = $song->duration;
    }

    if (!empty($song->lyricist)) {
        $musicLd['lyrics'] = [
            '@type' => 'CreativeWork',
            'author' => [
                '@type' => 'Person',
                'name' => $song->lyricist,
            ],
        ];
    }

    if (!empty($song->composer)) {
        $musicLd['composer'] = [
            '@type' => 'Person',
            'name' => $song->composer,
        ];
    }

    if (!empty($song->arranger)) {
        $musicLd['recordingOf'] = [
            '@type' => 'MusicComposition',
            'name' => $song->title,
            'musicArrangement' => $song->arranger,
        ];
    }

    if (!empty($song->center_members) && is_iterable($song->center_members)) {
        $musicLd['creditedTo'] = collect($song->center_members)->map(function ($cm) {
            return [
                '@type' => 'Person',
                'name' => $cm,
            ];
        })->values()->all();
    }
@endphp

@section('title', $titleCore)
@section('meta_description', $metaDescription)
@section('canonical', $canonicalUrl)
@section('robots', 'index,follow')
@section('og_title', $song->title . ' | SAKURA DATA 46')
@section('og_description', $metaDescription)
@section('og_type', 'music.song')
@section('og_url', $canonicalUrl)
@section('og_image', $songImage)
@section('og_image_alt', $song->title . '（櫻坂46）のジャケット画像')

@push('head_meta')
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
        },
        {
          "@type":"ListItem",
          "position":3,
          "name": @json($song->title),
          "item":"{{ $canonicalUrl }}"
        }
      ]
    }
    </script>

    <script type="application/ld+json">{!! json_encode($musicLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    <style>
        .video-wrapper {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin: 0 auto;
        }

        .video-wrapper iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        @media screen and (min-width: 768px) {
            .video-wrapper {
                width: 80%;
                padding-bottom: 45%;
            }
        }
    </style>
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-2 px-4" aria-label="パンくず">
    <ol class="flex space-x-2">
        <li><a href="{{ route('home') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
        <li>›</li>
        <li aria-current="page">{{ $song->title }}</li>
    </ol>
</nav>

<div class="container mx-auto mt-8 px-4">
    <article>
        <header>
            <h1 class="text-[2rem] text-[#c84e74] mb-2 border-b-2 border-[#f19db5] pb-[0.3rem] font-bold">
                {{ $song->title }}
            </h1>
        </header>

        <section class="flex flex-col md:flex-row mt-8 bg-white p-6 shadow-md" aria-labelledby="song-detail-heading">
            <div class="flex-shrink-0">
                <img
                    src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                    alt="{{ $song->title }}（櫻坂46）"
                    class="md:w-96 md:h-96 w-auto h-auto object-cover shadow-md"
                    loading="lazy"
                    width="384"
                    height="384"
                >
            </div>

            <div class="md:ml-8 mt-4 md:mt-0">
                <h2 id="song-detail-heading" class="text-xl font-semibold">詳細</h2>
                <ul class="mt-2 text-lg text-gray-800 space-y-1">
                    <li><strong>リリース日:</strong> {{ $releaseDate }}</li>
                    <li><strong>作詞:</strong> {{ $song->lyricist ?: '—' }}</li>
                    <li><strong>作曲:</strong> {{ $song->composer ?: '—' }}</li>
                    <li><strong>編曲:</strong> {{ $song->arranger ?: '—' }}</li>
                    <li><strong>収録:</strong> {{ $song->is_recorded ?: '—' }}</li>
                </ul>
            </div>
        </section>

        @if (!$recordedSongs->isEmpty())
            <section class="bg-white p-6 shadow-md mt-6" aria-labelledby="recorded-songs-heading">
                <h2 id="recorded-songs-heading" class="text-xl font-bold text-gray-800">同じ作品に収録されている楽曲</h2>
                <ul class="mt-2">
                    @foreach ($recordedSongs as $recordedSong)
                        <li class="block text-lg font-semibold hover:text-blue-600">
                            <a href="{{ route('songs.show', $recordedSong->id) }}">{{ $recordedSong->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        {{-- フォーメーション --}}
        @if (!empty($song->members))
            @php
                $sorted = $song->members->sortByDesc('pivot.row');
                $formation = $sorted
                    ->groupBy('pivot.row')
                    ->map(function ($rowMembers) {
                        return $rowMembers->sortBy('pivot.position')->values();
                    });
            @endphp

            <section class="bg-white p-4 sm:p-6 shadow-md mt-6" aria-labelledby="formation-heading">
                <h2 id="formation-heading" class="text-xl font-bold text-gray-800 mb-4">参加メンバー（フォーメーション）</h2>

                <div class="space-y-5 text-center">
                    @foreach ($formation as $rowNumber => $members)
                        @php
                            $count = $members->count();

                            $mobileGridColsClass = match ($count) {
                                1 => 'grid-cols-1',
                                2 => 'grid-cols-2',
                                3 => 'grid-cols-3',
                                4 => 'grid-cols-4',
                                5 => 'grid-cols-5',
                                6 => 'grid-cols-6',
                                7 => 'grid-cols-7',
                                default => 'grid-cols-3',
                            };
                        @endphp

                        {{-- モバイル: grid / PC: flex --}}
                        <div class="grid {{ $mobileGridColsClass }} justify-items-center gap-x-1 gap-y-4 sm:flex sm:justify-center sm:flex-wrap sm:gap-6 md:gap-8">
                            @foreach ($members as $member)
                                <div class="relative flex flex-col items-center min-w-0 w-full sm:w-16 md:w-20 lg:w-24">
                                    <a href="{{ route('members.show', $member->id) }}" class="hover:opacity-80 transition">
                                        <img
                                            src="{{ asset('storage/' . ($member->image ?? 'images/noimage.jpg')) }}"
                                            alt="{{ $member->name }}"
                                            class="w-9 h-9 sm:w-14 sm:h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 object-cover border-2 border-gray-300 shadow mx-auto"
                                        >
                                    </a>

                                    <div class="mt-1 text-[10px] sm:text-xs md:text-sm leading-tight font-semibold break-keep text-center">
                                        {{ $member->name }}
                                    </div>

                                    @if ($member->pivot->is_center)
                                        <span class="absolute -bottom-4 text-[10px] sm:text-xs text-red-500 font-bold bg-white px-1 rounded">
                                            CENTER
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <p class="mt-4 text-xs text-gray-500">楽曲によってはモバイル表示でフォーメーションの見え方が変わる場合があります。</p>
            </section>
        @else
            <p class="mt-4 text-gray-700">この楽曲にはまだ参加メンバーが登録されていません。</p>
        @endif

        @if (!empty($song->lyric))
            <section class="flex flex-col md:flex-row mt-8 bg-white p-6 shadow-md" aria-labelledby="lyrics-heading">
                <div class="mt-4 md:mt-0">
                    <h2 id="lyrics-heading" class="text-xl font-semibold mb-3">歌詞</h2>
                    <a href="{{ $song->lyric }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">
                        歌詞ページへ移動
                    </a>
                </div>
            </section>
        @endif

        @if (!empty($song->youtube))
            <section class="bg-white p-6 shadow-md mt-6" aria-labelledby="mv-heading">
                <h2 id="mv-heading" class="text-xl font-bold text-gray-800">ミュージックビデオ</h2>
                <div class="mt-4 video-wrapper">
                    {!! $song->youtube !!}
                </div>
            </section>
        @endif
    </article>
</div>

<script>
    (function () {
        const KEY = 'recentlyViewed';
        const list = JSON.parse(localStorage.getItem(KEY) || '[]');

        const item = {
            type: 'song',
            url: @json(route('songs.show', $song->id)),
            title: @json($song->title),
            image: @json(asset('storage/photos/' . ltrim($song->photo, '/'))),
        };

        const filtered = list.filter(x => x.url !== item.url);
        filtered.unshift(item);
        localStorage.setItem(KEY, JSON.stringify(filtered.slice(0, 12)));
    })();
</script>
@endsection