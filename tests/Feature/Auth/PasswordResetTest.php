<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_forgot_password_page_is_unavailable(): void
    {
        $this->get('/forgot-password')
            ->assertNotFound();
    }

    public function test_forgot_password_submission_is_unavailable(): void
    {
        $this->post('/forgot-password')
            ->assertNotFound();
    }

    public function test_reset_password_page_is_unavailable(): void
    {
        $this->get('/reset-password/test-token')
            ->assertNotFound();
    }

    public function test_reset_password_submission_is_unavailable(): void
    {
        $this->post('/reset-password')
            ->assertNotFound();
    }
}