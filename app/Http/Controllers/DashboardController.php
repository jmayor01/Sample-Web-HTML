<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'analytics' => $this->analyticsFor($user),
        ]);
    }

    /**
     * Build the analytics payload for the dashboard.
     *
     * This app doesn't track real visits or inquiries yet, so the engagement
     * figures are demo numbers seeded from the user's id — stable across
     * reloads for a given account instead of reshuffling on every request.
     *
     * @return array{
     *     daysActive: int,
     *     profileViews: int,
     *     profileViewsDelta: float,
     *     inquiries: int,
     *     inquiriesDelta: float,
     *     responseRate: int,
     *     completeness: int,
     *     completenessItems: list<array{label: string, done: bool}>,
     *     series: list<array{label: string, value: int}>,
     * }
     */
    private function analyticsFor(User $user): array
    {
        $seed = $user->id;
        $trend = $this->series($seed, days: 14, base: 40, spread: 55);

        $completenessItems = [
            ['label' => 'Name on file', 'done' => filled($user->name)],
            ['label' => 'Email on file', 'done' => filled($user->email)],
            ['label' => 'Email verified', 'done' => (bool) $user->email_verified_at],
        ];

        $completeness = 40 + (int) (array_sum(array_column($completenessItems, 'done')) * 20);

        return [
            'daysActive' => max(0, (int) $user->created_at?->diffInDays(now())),
            'profileViews' => array_sum(array_column($trend, 'value')),
            'profileViewsDelta' => $this->pseudoDelta($seed, 1),
            'inquiries' => $this->pseudoInt($seed, 2, 3, 41),
            'inquiriesDelta' => $this->pseudoDelta($seed, 3),
            'responseRate' => $this->pseudoInt($seed, 4, 92, 100),
            'completeness' => min(100, $completeness),
            'completenessItems' => $completenessItems,
            'series' => $trend,
        ];
    }

    /**
     * @return list<array{label: string, value: int}>
     */
    private function series(int $seed, int $days, int $base, int $spread): array
    {
        $points = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $value = $base + $this->pseudoInt($seed, 100 + $i, 0, $spread);

            $points[] = [
                'label' => now()->subDays($i)->format('M j'),
                'value' => $value,
            ];
        }

        return $points;
    }

    private function pseudoInt(int $seed, int $salt, int $min, int $max): int
    {
        $hash = crc32($seed.':'.$salt);

        return $min + ($hash % max(1, $max - $min + 1));
    }

    private function pseudoDelta(int $seed, int $salt): float
    {
        return round(($this->pseudoInt($seed, $salt, -180, 240)) / 10, 1);
    }
}
