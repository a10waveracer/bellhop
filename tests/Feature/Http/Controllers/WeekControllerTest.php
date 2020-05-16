<?php

namespace Tests\Feature\Http\Controllers;

use App\Week;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WeekController
 */
class WeekControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $weeks = factory(Week::class, 3)->create();

        $response = $this->get(route('week.index'));
    }
}
