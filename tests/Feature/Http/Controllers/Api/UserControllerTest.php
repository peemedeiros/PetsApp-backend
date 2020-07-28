<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_register_a_user_and_logging()
    {
        $faker = Factory::create();

        $response = $this->json('POST', '/api/v1/users', [
            "nome"                  => $name  = $faker->name,
            "email"                 => $email = $faker->email,
            "celular"               => $cell  = $faker->phoneNumber,
            "password"              => $password = $faker->password(8,20),
            "password_confirmation" => $password_confirmation = $password,
            "tipo_cadastro"         => $number = random_int(0,1)
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            "nome"                  => $name,
            "email"                 => $email,
            "celular"               => $cell,
            "tipo_cadastro"         => $number
        ]);

        $responseLogin = $this->json('POST', '/api/v1/login', [
            "email"     => $email,
            "password"  => $password
        ]);

        $responseLogin->assertJsonStructure([
            "user" => [
                "id", "nome", "email", "celular", "tipo_cadastro"
            ],
            "token"
        ])->assertStatus(200);

    }
}

