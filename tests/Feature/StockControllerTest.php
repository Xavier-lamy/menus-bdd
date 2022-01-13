<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Command;
use App\Models\Stock;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if Stocks method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly put in stocks
     *  - The product is correctly updated in commands
     *
     * @return void
     */
    public function testStoreInStock()
    {
        $this->withoutExceptionHandling();

        //Create a product in command for test purpose
        Command::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 1,
        ]);

        //Test a request for adding product in stocks
        $response = $this->post('/stocks/create', [
            'quantity' => 200,
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ]);

        //Check if the product we just add is added correctly in database
        $stock = Stock::where([
            'id' => 1,
            'quantity' => 200,
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ])->get();
        
        $this->assertTrue(!empty($stock));

        //Check if the product related to it in commands has been updated
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 200,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 0,
        ])->get();

        $this->assertTrue(!empty($command));

        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas([
                'success' => 'New product added to stocks',
            ]);
    }

    /**
     * Test if Stocks method "Update" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly updated in stocks
     *  - The product is correctly updated in commands
     *
     * @return void
     */
    public function testUpdateStock()
    {
        $this->withoutExceptionHandling();

        Command::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 200,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 1,
        ]);

        Stock::create([
            'id' => 1,
            'quantity' => 200,
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ]);

        $response = $this->post('/stocks/modify', [
            'id' => 1,
            'command_id' => 1,
            'useby_date' => '2002-11-01',
            'quantity' => 600,
        ]);

        //Check if the product we just update has been updated correctly
        $stock = Stock::where([
            'id' => 1,
            'quantity' => 600,
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ])->get();
        
        $this->assertTrue(!empty($stock));

        //Check if the product related to it in commands has been updated
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 600,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 0,
        ])->get();

        $this->assertTrue(!empty($command));

        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas([
                'success' => 'Product modified !',
            ]);
    }

    /**
     * Test if Stocks method "Destroy" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Return the correct amount of deleted entries
     *  - The product is correctly delete from stocks
     *  - The product is correctly updated in commands
     *
     * @return void
     */
    public function testDestroyStock()
    {
        $this->withoutExceptionHandling();

        Command::create([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 500,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 0,
        ]);

        //Create 2 products in stocks
        Stock::create([
            'id' => 1,
            'quantity' => 200,
            'useby_date' => '2002-11-01',
            'command_id' => 1,
        ]);

        Stock::create([
            'id' => 2,
            'quantity' => 300,
            'useby_date' => '2002-11-03',
            'command_id' => 1,
        ]);

        $response = $this->post('/stocks/delete', [
            'delete_1' => 1,
            'delete_2' => 2,
        ]);

        //Check if the products we delete are not there anymore
        $stock = Stock::find(1);
        $stock2 = Stock::find(2);
        
        $this->assertTrue(empty($stock) && empty($stock2));

        //Check if the product related to it in commands has been updated
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'flour',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 1,
        ])->get();

        $this->assertTrue(!empty($command));

        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas([
                'success' => '2 entries deleted !',
            ]);
    }
}
