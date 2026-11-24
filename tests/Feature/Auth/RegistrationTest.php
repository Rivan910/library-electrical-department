<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_is_unavailable(): void
    {
        $this->get('/register')
            ->assertNotFound();
    }

    public function test_registration_submission_is_unavailable(): void
    {
        $this->post('/register')
            ->assertNotFound();
    }
}