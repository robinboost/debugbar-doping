<?php

namespace Robinboost\DebugbarDoping\Tests\Feature;

use Robinboost\DebugbarDoping\Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_can_run_a_simple_test()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_send_request_to_api_route()
    {
        $response = $this->post('/_debugbar/check', [
            'token' => md5(config('debugbar-doping.secret_token')),
            'method' => 'list',
            'params' => []
        ]);

        $this->assertStringContainsString('Available commands:', $response->json()['message']);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_send_request_to_api_route_tag()
    {
        $response = $this->post('/_debugbar/check/tag', [
            'token' => md5(config('debugbar-doping.secret_token')),
            'tag' => 'test'
        ]);

        $this->assertStringContainsString('Done', $response->json()['message']);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_turn_on_turn_of()
    {
        $response = $this->post('/_debugbar/check', [
            'token' => md5(config('debugbar-doping.secret_token')),
            'method' => 'down',
            'params' => []
        ]);
        $this->assertStringContainsString('Application is now in maintenance mode', $response->json()['message']);
        $response->assertStatus(200);

        $response = $this->post('/_debugbar/check', [
            'token' => md5(config('debugbar-doping.secret_token')),
            'method' => 'up',
            'params' => []
        ]);
        dd($response->json());
        $this->assertStringContainsString('Done', $response->json()['message']);
        $response->assertStatus(200);
    }
}