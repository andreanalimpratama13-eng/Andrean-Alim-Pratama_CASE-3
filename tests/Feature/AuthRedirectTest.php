<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_uses_requested_application_name(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Stok Barang di Gudang')
            ->assertSee('Manajemen barang')
            ->assertSee('images/owl-logo.svg')
            ->assertSee('bg-[#EFF6FF]', false);
    }

    public function test_registration_redirects_to_barangs(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('barangs.index'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertTrue(Hash::check('password123', User::where('email', 'test@example.com')->firstOrFail()->password));
    }

    public function test_registration_page_uses_the_owl_logo(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('images/owl-logo.svg');
    }

    public function test_login_redirects_to_barangs_even_with_an_intended_url(): void
    {
        $user = User::factory()->create();

        $response = $this->withSession(['url.intended' => '/dashboard'])
            ->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(route('barangs.index'));
    }
}
