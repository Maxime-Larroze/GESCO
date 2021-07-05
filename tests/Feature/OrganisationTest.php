<?php

namespace Tests\Feature;

use App\Models\Organisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganisationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAddOrganosation()
    {
        $organisation = Organisation::create(['id' => 'uuid', 'slug' => 'TEST-0001-DEV', 'name' => 'nom', 'email' => 'email@email.fr', 'tel' => '0102030405', 'address' => '1 rue bravo', 'type' => 0]);
        $this->assertSame('nom', $organisation->name);
    }
}
