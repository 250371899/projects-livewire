<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
// Test if render works
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }
    /**
     * Test if user with valid 
     * unique email, 
     * at least 10 char unique username,
     * strong password min 8 chars with no db leak known, at least 1 uppercase and 1 lowercase and 1 number and 1 special char
     * @return void
     */
    public function test_new_users_can_register(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'helloWorld1@@')
            ->set('password_confirmation', 'helloWorld1@@');

        $component->call('register');
           
        $component->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();
    }

    /**
         * Test registration with username less than 10 char
         * @return void
         */
        public function test_new_users_can_register_with_weak_short_username(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'test')
            ->set('password', 'helloWorld1@')
            ->set('password_confirmation', 'helloWorld1@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }

        /**
         * Test registration with username not unique
         * @return void
         */
        public function test_new_users_can_register_with_not_unique_username(): void
    {
        User::factory()->create([
        'email' => 'hellohello@google.com',
        'username' => 'testtest11',
    ]);
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'newhello@google.com')
            ->set('username', 'testtest11') // not unique
            ->set('password', 'helloWorld1@@')
            ->set('password_confirmation', 'helloWorld1@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }


        /**
         * Test registration with email not unique 
         * @return void
         */
        public function test_new_users_can_register_with_not_unique_email(): void
    {
        User::factory()->create([
        'email' => 'hellohello@google.com',
        'username' => 'testtest10',
    ]);
        $component = Volt::test('pages.auth.register')
       ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest10')
            ->set('password', 'helloWorld1@@')
            ->set('password_confirmation', 'helloWorld1@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password leak
         * @return void
         */
        public function test_new_users_can_register_with_leak_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'helloWorld1@') // passwor leaked
            ->set('password_confirmation', 'helloWorld1@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password w/ at least 1 upper 1 lower 1spec char no db leak but less 8 char
         * @return void
         */
        public function test_new_users_can_register_with_less_eight_char_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'hQ@') // lower case uppercase and special char
            ->set('password_confirmation', 'hQ@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password w/o uppercase
         * @return void
         */
        public function test_new_users_can_register_without_uppcase_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'helloworld1@@') // w/o uppercase
            ->set('password_confirmation', 'helloworld1@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password w/o lowercase
         * @return void
         */
        public function test_new_users_can_register_without_lowercase_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'HELLOWORLD1@@') // w/o lowercase
            ->set('password_confirmation', 'HELLOWORLD1@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password w/o NUMBER
         * @return void
         */
        public function test_new_users_can_register_without_number_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'helloWorld@@@') // w/o number
            ->set('password_confirmation', 'helloWorld@@@');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }
        /**
         * Test registration with password without special char
         * @return void
         */
        public function test_new_users_can_register_with_no_spec_char_password(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'hellohello@google.com')
            ->set('username', 'testtest11')
            ->set('password', 'helloWorld11') // w/o special char 
            ->set('password_confirmation', 'helloWorld11');

        $component->call('register');
           
        $component->assertNoRedirect();

        $this->assertGuest();
    }


}
