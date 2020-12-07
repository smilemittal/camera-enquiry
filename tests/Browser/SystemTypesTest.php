<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SystemTypesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {


            $browser->visit(route('system_types.create'))
                ->type('name','test')
                ->press('submit')
                ->assertSee("System type added successfully")       
                ->pause(2000); 

            $browser->visit(route('system_types.index'))
                ->with('#system_types', function ($table) {
                    $table->assertSee('Pepsi')
                ->click('btnSearchDrop12')
                ->pause(1000)
                ->click('a.edit');
            })
                ->type('name', 'update-test')
                ->press('submit')
                ->assertSee('System type updated successfully.');

            $browser->visit(route('system_types.delete'))
                ->with('#system_types', function ($table) {
            $table->assertSee('Pepsi')
                ->click('btnSearchDrop12')
                ->pause(1000)
                ->click('a.delete');
            })
            ->pause(1000)
            ->assertSee("System type deleted successfully");    
           
           });
    }
}
