@extends('layouts.main')

@section('title', 'データ一覧・統計 | SAKURA DATA 46')
@section('meta_description', '櫻坂46データベースSAKURA DATA 46の各種データページへのリンク集です。メンバー一覧、楽曲一覧、検索、YouTube人気動画ランキングなどにアクセスできます。')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">
        データ一覧・統計ページ
    </h1>

    <p class="text-gray-700 mb-8">
        SAKURA DATA 46で公開している、櫻坂46に関する各種データページへのリンク集です。  
        今後増やしていく予定です。
    </p>

    {{-- 公開データ --}}
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">公開データ</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">

            {{-- YouTube人気動画 --}}
            <a href="{{ route('youtube.ranking') }}"
                class="bg-white shadow-md p-4 text-center hover:scale-105 transition-transform block">
                <div class="flex flex-col items-center">
                    <span class="text-lg font-semibold">櫻坂ちゃんねる人気動画ランキング</span>
                    <p class="text-xs text-gray-500 mt-1">櫻坂46公式YouTubeチャンネル「櫻坂ちゃんねる」の人気動画を再生数順に紹介</p>
                </div>
            </a>

        </div>
    </section>

    {{-- 将来追加予定のデータ（ダミー枠） --}}
    {{-- <section class="mb-10">
        <h2 class="text-xl font-semibold mb-4">今後追加予定のデータ</h2>
        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
            <li>人気ページランキング / アクセス解析</li>
            <li>期別・属性別の統計データ</li>
            <li>メンバーのスキル・特徴データ集計</li>
            <li>歌唱パート・センター回数などの可視化</li>
        </ul>
    </section> --}}

</div>
@endsection
