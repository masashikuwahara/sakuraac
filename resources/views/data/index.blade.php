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
        メンバー・楽曲・検索・YouTubeランキングなど、ここからアクセスできます。
    </p>

    {{-- 公開データ --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold mb-4">公開データ</h2>

        <div class="grid gap-4 md:grid-cols-2">
            {{-- メンバー一覧 --}}
            <a href="{{ route('members.index') }}"
               class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                <h3 class="text-lg font-semibold mb-1">メンバー一覧</h3>
                <p class="text-sm text-gray-600">
                    現役メンバーのプロフィールや期別、絞り込み検索などができます。
                </p>
                <p class="mt-2 text-xs text-gray-500">
                    ルート: <code>members.index</code> / URL: <code>/members</code>
                </p>
            </a>

            {{-- 楽曲一覧 --}}
            <a href="{{ route('songs.index') }}"
               class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                <h3 class="text-lg font-semibold mb-1">楽曲一覧</h3>
                <p class="text-sm text-gray-600">
                    櫻坂46の楽曲情報（タイトル・発売日・フォーメーションなど）を一覧で閲覧できます。
                </p>
                <p class="mt-2 text-xs text-gray-500">
                    ルート: <code>songs.index</code> / URL: <code>/songs</code>
                </p>
            </a>

            {{-- サイト内検索 --}}
            <a href="{{ route('search') }}"
               class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                <h3 class="text-lg font-semibold mb-1">サイト内検索</h3>
                <p class="text-sm text-gray-600">
                    メンバー名や楽曲名など、キーワードでサイト内データを検索できます。
                </p>
                <p class="mt-2 text-xs text-gray-500">
                    ルート: <code>search</code> / URL: <code>/search</code>
                </p>
            </a>

            {{-- YouTube人気動画ランキング --}}
            <a href="{{ route('youtube.ranking') }}"
               class="block border rounded-lg p-5 hover:bg-gray-50 transition">
                <h3 class="text-lg font-semibold mb-1">櫻坂ちゃんねる 人気動画ランキング</h3>
                <p class="text-sm text-gray-600">
                    櫻坂46公式YouTube「櫻坂ちゃんねる」の人気動画ランキングや最新動画を表示します。
                </p>
                <p class="mt-2 text-xs text-gray-500">
                    ルート: <code>youtube.ranking</code> / URL: <code>/youtube/ranking</code>
                </p>
            </a>
        </div>
    </section>

    {{-- 将来追加予定のデータ（ダミー枠） --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold mb-4">今後追加予定のデータ</h2>
        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
            <li>人気ページランキング / アクセス解析</li>
            <li>期別・属性別の統計データ</li>
            <li>メンバーのスキル・特徴データ集計</li>
            <li>歌唱パート・センター回数などの可視化</li>
        </ul>
    </section>

    {{-- 管理者向けリンク（ログイン時のみ表示） --}}
    @auth
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
    @endauth
</div>
@endsection
