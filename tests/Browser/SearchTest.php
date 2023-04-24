<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchTest extends DuskTestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_return_query_results(): void
    {
        $this->browse(function (Browser $browser) {
            $query = 'lorem ipsum test';
            $browser->visit('/search')
                    ->value('#voice-search', $query)
                    ->click('button[type="submit"]')
                    ->assertPathIs('/search/results')
                    ->waitForText($query)
                    ->assertSee('about 38,000 results (0.31 seconds)');
        });
    }
}
