@extends('layouts.main')

@section('title', 'データ一覧・統計 | SAKURAAC')
@section('meta_description', '櫻坂46データベースSAKURAACの各種データページへのリンク集です。メンバー一覧、楽曲一覧、検索、YouTube人気動画ランキングなどにアクセスできます。')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">
        データ一覧・統計ページ
    </h1>

    <p class="text-gray-700 mb-8">
        SAKURAACで公開している、櫻坂46に関する各種データページへのリンク集です。  
        YouTubeランキングなど、ここからアクセスできます。
    </p>

    {{-- 公開データ --}}
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">公開データ</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">

            {{-- YouTube人気動画 --}}
            <a href="{{ route('youtube.ranking') }}"
                class="bg-white shadow-md p-4 text-center hover:scale-105 transition-transform rounded-lg block">
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

    {{-- 管理者向けリンク（ログイン時のみ表示） --}}
    {{-- @auth
        <section class="mb-4">
            <h2 class="text-xl font-semibold mb-4">管理用データ（ログインユーザーのみ）</h2>

            <div class="grid gap-4 md:grid-cols-2">
                <a href="{{ route('admin.index') }}"
                   class="block border rounded-lg p-5 bg-gray-50 hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold mb-1">管理ダッシュボード</h3>
                    <p class="text-sm text-gray-600">
                        サイト全体の管理メニューへ移動します。
                    </p>
                    <p class="mt-2 text-xs text-gray-500">
                        ルート: <code>admin.index</code> / URL: <code>/admin</code>
                    </p>
                </a>

                <a href="{{ route('admin.members') }}"
                   class="block border rounded-lg p-5 bg-gray-50 hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold mb-1">メンバー情報管理</h3>
                    <p class="text-sm text-gray-600">
                        メンバープロフィールや画像、スキルなどの管理を行います。
                    </p>
                    <p class="mt-2 text-xs text-gray-500">
                        ルート: <code>admin.members</code> / URL: <code>/admin/members</code>
                    </p>
                </a>

                <a href="{{ route('admin.songs') }}"
                   class="block border rounded-lg p-5 bg-gray-50 hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold mb-1">楽曲情報管理</h3>
                    <p class="text-sm text-gray-600">
                        楽曲データ・フォーメーション情報などの管理を行います。
                    </p>
                    <p class="mt-2 text-xs text-gray-500">
                        ルート: <code>admin.songs</code> / URL: <code>/admin/songs</code>
                    </p>
                </a>

                <a href="{{ route('admin.changelogs.index') }}"
                   class="block border rounded-lg p-5 bg-gray-50 hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold mb-1">更新履歴管理</h3>
                    <p class="text-sm text-gray-600">
                        サイトの更新履歴（リリースノート）を登録・管理します。
                    </p>
                    <p class="mt-2 text-xs text-gray-500">
                        ルート: <code>admin.changelogs.index</code> / URL: <code>/admin/changelogs</code>
                    </p>
                </a>
            </div>
        </section>
    @endauth --}}
</div>
@endsection
