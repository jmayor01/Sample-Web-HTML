<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_see_their_analytics(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Live Analytics');
        $response->assertSee('Profile Views');
        $response->assertSee('Profile Completeness');
    }

    public function test_analytics_are_stable_across_requests_for_the_same_user(): void
    {
        $user = User::factory()->create();

        $first = $this->actingAs($user)->get('/dashboard');
        $second = $this->actingAs($user)->get('/dashboard');

        $extractCounts = fn (string $html) => preg_match_all('/data-count-to="([^"]+)"/', $html, $matches) ? $matches[1] : [];

        $this->assertSame($extractCounts($first->getContent()), $extractCounts($second->getContent()));
    }
}
