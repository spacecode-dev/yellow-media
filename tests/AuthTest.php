<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testAuthRegister()
    {
        $response = $this->json(
            'POST',
            '/api/user/register',
            [
                'first_name' => 'Sally',
                'email' => 'test@gmail.com',
                'password' => 'password',
            ]
        );

        $response->seeJson([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);

        $response->seeInDatabase(
            'users',
            [
                'first_name' => 'Sally',
                'name' => 'Sally',
                'email' => 'test@gmail.com',
            ]
        );
    }

    /**
     * @return void
     */
    public function testAuthSingInWrongEmail()
    {
        $response = $this->json(
            'POST',
            '/api/user/sign-in',
            [
                'email' => 'wrong@gmail.com',
                'password' => 'password',
            ]
        );

        $response->assertEquals(403, $response->response->status());

        $response->seeJson([
            'status' => 'error',
            'message' => 'There is no user with such email'
        ]);
    }

    /**
     * @return void
     */
    public function testAuthSingInWrongCredentials()
    {
        $response = $this->json(
            'POST',
            '/api/user/sign-in',
            [
                'email' => 'user@gmail.com',
                'password' => 'passwordWrong',
            ]
        );

        $response->assertEquals(403, $response->response->status());

        $response->seeJson([
            'status' => 'error',
            'message' => 'These credentials do not match our records'
        ]);
    }

    /**
     * @return void
     */
    public function testAuthSingInSuccess()
    {
        $response = $this->json(
            'POST',
            '/api/user/sign-in',
            [
                'email' => 'user@gmail.com',
                'password' => 'password',
            ]
        );

        $response->seeJsonStructure(['status', 'api_token']);
    }
}
