<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Song;
use App\Models\Changelog;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Tokyo')->startOfDay();

        $members = Member::inRandomOrder()->take(8)->get();

        $songs = Song::inRandomOrder()->take(8)->get();

        $logs = Changelog::ordered()->limit(20)->get();
        
        $birthdayMembers = Member::query()
            ->whereMonth('birth', $today->month)
            ->whereDay('birth', $today->day)
            ->orderBy('furigana')
            ->get();

        return view('index', compact('members','songs' ,'logs' ,'birthdayMembers'));
    }
}