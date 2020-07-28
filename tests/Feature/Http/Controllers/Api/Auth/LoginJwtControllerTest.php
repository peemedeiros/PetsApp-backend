<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginJwtControllerTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_loggin()
    {

        $response = $this->json('POST', '/api/v1/login', [
            "email"     => "pedro@gmail.com",
            "password"  => "123123123"
        ]);

        $response->assertJsonStructure([
            "user" => [
                "id", "nome", "email", "celular", "tipo_cadastro"
            ],
            "token"
        ])
        ->assertStatus(200);


    }
}
