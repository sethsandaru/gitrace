<?php

namespace App\Http\Controllers;

use App\DataCache\UserTodayContributionsDataCache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function check(Request $request): View
    {
        $usernames = array_map('trim', explode(',', $request->input('usernames')));
        if (count($usernames) < 2) {
            abort(400, 'We need at least 2 usernames in order to compare');
        }

        $userContributions = collect(array_map(fn (string $username) => [
            'username' => $username,
            'avatarUrl' => "https://github.com/$username.png",
            'githubUrl' => "https://github.com/$username",
            'total' => (new UserTodayContributionsDataCache($username))->get()
        ], $usernames));

        $userContributions = $userContributions->sortByDesc('total')->values();

        return view('statistic', [
            'userContributions' => $userContributions,
            'today' => Carbon::now()->toDateString(),
        ]);
    }
}
