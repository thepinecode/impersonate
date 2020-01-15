<?php

namespace Pine\Impersonate\Tests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Pine\Impersonate\Events\ChangedToUser;
use Pine\Impersonate\Events\Reverted;

class ImpersonateTest extends TestCase
{
    /** @test */
    public function a_guest_cannot_impersonate_a_user()
    {
        $this->get("impersonate/{$this->user->id}")
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_cant_impersonate_itself()
    {
        $this->actingAs($this->admin)
            ->get("impersonate/{$this->admin->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_impersonate_an_other_user()
    {
        Event::fake();

        $response = $this->actingAs($this->admin)
            ->get("impersonate/{$this->user->id}")
            ->assertRedirect('impersonate-test');

        $this->followRedirects($response)
            ->assertSee('Impersonating')
            ->assertSessionHas('original_user', $this->admin->id);

        $this->assertEquals($this->user->id, Auth::id());

        Event::assertDispatched(ChangedToUser::class, function ($e) {
            return $e->user->id === $this->user->id;
        });
    }

    /** @test */
    public function an_impersonating_user_can_revert_to_its_original_user()
    {
        Event::fake();

        $this->actingAs($this->admin)
            ->get("impersonate/{$this->user->id}");

        $response = $this->actingAs($this->user)
            ->get('impersonate/revert')
            ->assertRedirect('impersonate-test');

        $this->followRedirects($response)
            ->assertSee('Not impersonating')
            ->assertSessionMissing('original_user');

        $this->assertEquals($this->admin->id, Auth::id());

        Event::assertDispatched(Reverted::class);
    }
}
