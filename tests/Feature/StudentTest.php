<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentTest extends TestCase
{
    /** @test */
    public function it_can_view_students()
    {
        $response = $this->get('/view');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_export_students()
    {

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $x = $this->post(route('export'), $data);
        var_dump($x);
    }
}
