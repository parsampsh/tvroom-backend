<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusCheckTest extends TestCase
{
    /**
     * Status check API responses
     *
     * @return void
     */
    public function test_status_check_api_responses()
    {
        $response = $this->get(route('api.v1.status'));
        $response->assertStatus(200);
    }
}
