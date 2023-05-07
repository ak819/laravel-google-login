<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    
    public function test_login_view()
    {
       $response=$this->get('/login');
       $response->assertStatus('200');
    }
}
