<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Command;
use App\Models\Stock;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if Commands method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly added in commands
     *
     * @return void
     */
    public function testStoreInCommand()
    {
        $this->withoutExceptionHandling();
        //Test a request for adding product
        $response = $this->post('/total-stocks/create', [
            'ingredient' => 'flour',
            'quantity_name' => 'grams',
            'alert_stock' => 200,
        ]);

        //Check if the product has been added
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 0,
            'quantity_name' => 'grams',
            'alert_stock' => 200,
            'must_buy' => 1,
        ])->get();

        $this->assertTrue(!empty($command));

        $response
            ->assertRedirect('/total-stocks')
            ->assertSessionHas([
                'success' => 'Product successfully added !',
            ]);
    }

    /**
     * Test if Commands method "Update" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly updated in commands
     *  - The product is correctly updated in stocks
     *
     * @return void
     */
    public function testUpdateCommand()
    {
        $this->withoutExceptionHandling();

        Command::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 200,
            'quantity_name' => 'grams',
            'alert_stock' => 400,
            'must_buy' => 1,
        ]);

        Stock::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 200,
            'quantity_name' => 'grams',
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ]);

        $response = $this->post('/total-stocks/modify', [
            'id' => 1,
            'ingredient' => 'sugar',
            'quantity_name' => 'bags',
            'alert_stock' => 100,
        ]);

        //Check if the product has been updated in commands
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'sugar',
            'quantity' => 200,
            'quantity_name' => 'bags',
            'alert_stock' => 100,
            'must_buy' => 0,
        ])->get();

        $this->assertTrue(!empty($command));

        //Check if the related product has been updated in stocks
        $stock = Stock::where([
            'id' => 1,
            'ingredient' => 'sugar',
            'quantity' => 200,
            'quantity_name' => 'bags',
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ])->get();
        
        $this->assertTrue(!empty($stock));

        $response
            ->assertRedirect('/total-stocks')
            ->assertSessionHas([
                'success' => 'Product modified !',
            ]);
    }

    /**
     * Test if Commands method "Destroy" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Return the correct amount of deleted entries
     *  - The product is correctly delete from both commands and stocks
     *
     * @return void
     */
    public function testDestroyCommand()
    {
        $this->withoutExceptionHandling();

        Command::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 500,
            'quantity_name' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 0,
        ]);

        //Create 2 products in stocks
        Stock::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 200,
            'quantity_name' => 'grams',
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ]);

        Stock::create([
            'id' => 2,
            'ingredient' => 'flour',
            'quantity' => 300,
            'quantity_name' => 'grams',
            'useby_date' => '2002-11-03',
            'command_id' => 1,
        ]);

        $response = $this->post('/total-stocks/delete', [
            'delete_1' => 1,
        ]);

        //Check if the products we delete are not there anymore, both in stocks and commands
        $command = Command::find(1);
        $stock = Stock::find(1);
        $stock2 = Stock::find(2);
         
        $this->assertTrue(empty($command));
        $this->assertTrue(empty($stock) && empty($stock2));

        $response
            ->assertRedirect('/total-stocks')
            ->assertSessionHas([
                'success' => '1 entry deleted !',
            ]);
    }
}
