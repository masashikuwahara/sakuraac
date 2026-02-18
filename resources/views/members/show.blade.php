@extends('layouts.main')

@php
  $name = $member->name;
  $furigana = trim((string)($member->furigana ?? ''));
  $furiganaNoSpace = preg_replace('/\s+/u', '', $furigana);

  $alternateNames = array_values(array_filter(array_unique([
    $furigana,
    $furiganaNoSpace,
  ])));

  $titleCore = !empty($member->height)
    ? "{$name}｜身長{$member->height}cm・あだ名・プロフィール"
    : "{$name}｜あだ名・プロフィール";

  $descParts = [];
  $descParts[] = "{$name}".($furigana ? "（{$furigana}）" : "")."のプロフィール。";
  if (!empty($member->height))   $descParts[] = "身長{$member->height}cm。";
  if (!empty($member->nickname)) $descParts[] = "あだ名：{$member->nickname}。";
  $descParts[] = "参加曲・選抜情報などをまとめています。";
  $metaDescription = \Illuminate\Support\Str::limit(implode('', $descParts), 120);

  // OG/表示用画像（統一）
  $memberImage = $member->image_url
    ?: (!empty($member->image) ? asset('storage/'.$member->image) : 'https://sakurazaka46.live/storage/images/logo.png');

  // birthDate：birthday/birthどちらでも拾う
  $birthRaw = $member->birthday ?? $member->birth ?? null;
@endphp

@section('title', $titleCore)
@section('meta_description', $metaDescription)

@push('head_meta')
  {{-- OG --}}
  @section('og_title', $titleCore . ' | SAKURA DATA 46')
  @section('og_description', $metaDescription)
  @section('og_image', $memberImage)

  <meta property="og:type" content="profile">
  <meta property="profile:username" content="{{ $name }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  {{-- Person JSON-LD --}}
  @php
    $person = [
      '@context' => 'https://schema.org',
      '@type'    => 'Person',
      'name'     => $name,
      'url'      => url()->current(),
      'image'    => $memberImage,
      'memberOf' => ['@type' => 'MusicGroup', 'name' => '櫻坂46'],
    ];

    if (!empty($alternateNames)) {
      $person['alternateName'] = $alternateNames;
    }

    if (!empty($member->height)) {
      $person['height'] = [
        '@type' => 'QuantitativeValue',
        'value' => (int)$member->height,
        'unitText' => 'cm'
      ];
    }

    if (!empty($birthRaw)) {
      $person['birthDate'] = \Carbon\Carbon::parse($birthRaw)->toDateString();
    }

    if (!empty($member->sns)) {
      $person['sameAs'] = [$member->sns];
    }
  @endphp
  <script type="application/ld+json">{!! json_encode($person, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

  {{-- Breadcrumb JSON-LD --}}
  <script type="application/ld+json">
  {
   "@context":"https://schema.org",
   "@type":"BreadcrumbList",
   "itemListElement":[
    {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
    {"@type":"ListItem","position":2,"name":"メンバー","item":"{{ route('members.index') }}"},
    {"@type":"ListItem","position":3,"name":"{{ $name }}","item":"{{ url()->current() }}"}
   ]
  }
  </script>

  {{-- VideoObject JSON-LD（promotion_video がある時だけ出力） --}}
  @if (!empty($member->promotion_video))
    @php
      $videoLd = [
        '@context'     => 'https://schema.org',
        '@type'        => 'VideoObject',
        'name'         => $name . ' 個人PV（予告編）',
        'description'  => $name . 'の個人PV（YouTube公式）',
        'thumbnailUrl' => [$memberImage],
      ];

      if (preg_match('/src="([^"]+)"/', $member->promotion_video, $m)) {
        $videoLd['embedUrl'] = $m[1];
      }
    @endphp
    <script type="application/ld+json">
    {!! json_encode($videoLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
    </script>
  @endif
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-4" aria-label="パンくず">
  <ol class="flex space-x-2">
    <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
    <li>›</li>
    <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー</a></li>
    <li>›</li>
    <li aria-current="page">{{ $member->name }}</li>
  </ol>
</nav>

<main class="container mx-auto mt-8 px-4">
  <h1 class="text-[2rem] text-[#c84e74] mb-2 border-b-2 border-[#f19db5] pb-[0.3rem] font-bold">{{ $member->name }}</h1>
  {{-- <p class="text-xl mt-2">{{ $member->furigana }}</p> --}}

  @if (!empty($alternateNames))
    <p class="text-xl text-gray-600 mt-1">{{ implode(' / ', $alternateNames) }}</p>
  @endif

  <section class="flex flex-col md:flex-row items-center mt-8 bg-[#fcf3f6] p-6 shadow-md">
    <div class="flex-shrink-0">
      <img src="{{ $memberImage }}"
           alt="{{ $member->name }} （櫻坂46）"
           class="w-56 h-72 md:w-96 md:h-[32rem] object-cover shadow-md"
           loading="lazy"
           width="384" height="512"
      />
    </div>

    <div class="md:ml-8 mt-4 md:mt-0">
      <h2 class="text-xl font-semibold">プロフィール</h2>
      <ul class="mt-2 text-gray-800">
        <li><strong>ニックネーム:</strong> {{ $member->nickname ?: '—' }}</li>
        <li><strong>生年月日:</strong>
          {{ !empty($member->birth) ? \Carbon\Carbon::parse($member->birth)->format('Y年m月d日') : (!empty($member->birthday) ? \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日') : '—') }}
        </li>
        <li><strong>星座:</strong> {{ $member->constellation ?: '—' }}</li>
        <li><strong>身長:</strong>
          <span class="font-bold text-[#c84e74]">{{ !empty($member->height) ? $member->height.'cm' : '—' }}</span>
        </li>
        <li><strong>血液型:</strong> {{ $member->blood ?: '—' }}</li>
        <li><strong>出身地:</strong> {{ $member->birthplace ?: '—' }}</li>
        <li><strong>加入:</strong> {{ $member->grade ?: '—' }}</li>

        <li><strong>参加楽曲数:</strong> {{ $songCount }}</li>
        <li><strong>選抜回数:</strong> {{ $titlesongCount }}</li>
        <li><strong>センター曲数:</strong> {{ $centerCount }}</li>

        <li>
          <strong class="mr-2">ペンライトカラー:</strong>
          <div class="inline-flex items-center space-x-4 mt-2">
            <div class="px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color1 }}">
              {{ $member->colorname1 }}
            </div>
            <div class="px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color2 }}">
              {{ $member->colorname2 }}
            </div>
          </div>
        </li>

        @if ($member->sns)
          <li class="flex items-center">
            <strong>SNS:</strong>&nbsp;
            <a href="{{ $member->sns }}" target="_blank" rel="noopener noreferrer">
              <img src="{{ asset('/storage/photos/insta.png') }}"
                   alt="insta"
                   class="w-7 object-cover rounded-lg shadow-md">
            </a>
          </li>
        @endif

        <li><strong>キャラクター:</strong> {{ $member->introduction ?: '—' }}</li>
      </ul>
    </div>
  </section>

  {{-- 検索されやすい項目 --}}
  <section class="mt-8 bg-[#fcf3f6] p-6 shadow-md">
    <h2 class="text-xl font-bold text-gray-800">あだ名</h2>
    <p class="mt-2">{{ $member->nickname ?: '—' }}</p>

    <h2 class="text-xl font-bold text-gray-800 mt-6">身長</h2>
    <p class="mt-2">{{ !empty($member->height) ? $member->height.'cm' : '—' }}</p>

    <h2 class="text-xl font-bold text-gray-800 mt-6">選抜</h2>
    <p class="mt-2">選抜回数：{{ $titlesongCount }}回</p>
  </section>

  {{-- 公式ブログ --}}
  @if (!empty($member->blog))
    <section class="flex flex-col md:flex-row items-start mt-8 bg-[#fcf3f6] p-6 shadow-md">
      <h2 class="text-xl font-bold mb-4 md:mb-0 md:mr-4 md:flex-none">公式ブログ</h2>
      <div class="mt-2 text-blue-700 font-semibold hover:text-indigo-600 md:mt-0 md:flex-1">
        {!! $blogHtml !!}
      </div>
    </section>
  @endif

    {{-- 同期メンバー --}}
    @if(isset($sameGenMembers) && $sameGenMembers->isNotEmpty())
        <section class="mt-8 bg-[#fcf3f6] p-6 shadow-md ">
            <h2 class="text-xl font-semibold mb-4">
                同じ{{ $member->grade }}メンバー
            </h2>
            <ul class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($sameGenMembers as $mate)
                    <li class="text-center">
                        <a href="{{ route('members.show', $mate->id) }}" class="block hover:opacity-80">
                            <img
                                src="{{ asset('storage/' . $mate->image) }}"
                                alt="{{ $mate->name }}"
                                class="w-20 h-20 sm:w-24 sm:h-24 object-cover mx-auto shadow"
                                loading="lazy"
                                width="96" height="96"
                            >
                            <span class="mt-2 text-sm font-bold block">{{ $mate->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

  {{-- 個人PV --}}
  @if (!empty($member->promotion_video))
    <section class="bg-[#fcf3f6] p-6 shadow-md mt-6">
      <h3 class="text-xl font-bold text-gray-800">個人PV</h3>
      <div class="mt-4 video-wrapper">
        {!! $member->promotion_video !!}
      </div>
    </section>
  @endif

  <!-- 表示切り替えボタン -->
  <div class="mt-6 space-x-4">
    <button onclick="showAllSongs()" class="bg-green-500 text-white py-2 px-4 hover:bg-green-700 transition">
      すべて表示
    </button>
    <button onclick="showCenterOnly()" class="bg-emerald-500 text-white py-2 px-4 hover:bg-emerald-700 transition">
      センター曲のみ表示
    </button>
  </div>

  <!-- 参加楽曲リスト -->
  <section class="mt-8">
    <h2 class="text-2xl font-semibold">参加楽曲</h2>
    @if ($member->songs->isEmpty())
      <p class="mt-2 text-gray-700">まだ参加楽曲はありません。</p>
    @else
      <ul id="songList" class="mt-4 space-y-2">
        @foreach ($member->songs as $song)
          <li class="bg-[#fcf3f6] p-4 shadow-md" data-center="{{ $song->pivot->is_center ? '1' : '0' }}">
            <a href="{{ route('songs.show', $song->id) }}" class="block text-lg font-semibold hover:text-blue-600">
              {{ $song->title }}
              @if ($song->pivot->is_center)
                <strong class="text-red-600">（センター）</strong>
              @endif
            </a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  {{-- トップに戻るボタン --}}
  <button id="back-to-top" title="トップへ戻る">TOP</button>

  <script>
    const button = document.getElementById("back-to-top");
    window.addEventListener("scroll", function () {
      if (window.pageYOffset > 300) button.classList.add("show");
      else button.classList.remove("show");
    });
    button.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    function showAllSongs() {
      document.querySelectorAll('#songList li').forEach(item => item.style.display = 'block');
    }
    function showCenterOnly() {
      document.querySelectorAll('#songList li').forEach(item => {
        item.style.display = (item.dataset.center === '1') ? 'block' : 'none';
      });
    }
  </script>

  {{-- 閲覧記録（画像はmemberImageを使う） --}}
  <script>
    (function () {
      const KEY = 'recentlyViewed';
      const list = JSON.parse(localStorage.getItem(KEY) || '[]');

      const item = {
        type: 'member',
        url: @json(route('members.show', $member->id)),
        title: @json($member->name),
        image: @json($memberImage),
      };

      const filtered = list.filter(x => x.url !== item.url);
      filtered.unshift(item);
      localStorage.setItem(KEY, JSON.stringify(filtered.slice(0, 12)));
    })();
  </script>
</main>
@endsection
