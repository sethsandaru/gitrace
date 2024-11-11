<?php

namespace App\Services\GitHub;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GetTotalContributions
{
    public static function get(
        string $username,
        Carbon $start,
        Carbon $end
    ): int {
        $res = Http::withToken(config('services.github.personal_access_token'))
            ->asJson()
            ->post('https://api.github.com/graphql', [
                'query' => '
                    query($username: String!, $fromDate: DateTime!, $toDate: DateTime!) {
                        user(login: $username) {
                            contributionsCollection(from: $fromDate, to: $toDate) {
                                contributionCalendar {
                                    totalContributions
                                }
                            }
                        }
                    }
                ',
                'variables' => [
                    'username' => $username,
                    'fromDate' => $start->utc()->toISOString(),
                    'toDate' => $end->utc()->toISOString(),
                ],
            ]);

        return $res->json('data.user.contributionsCollection.contributionCalendar.totalContributions', 0);
    }
}
