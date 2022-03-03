<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Tests\TestCase;
use App\Models\Command;
use App\Models\Stock;
use App\Models\User;

class StockTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Prepare the database for tests with the test seeders
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->seed(TestDatabaseSeeder::class);

        $this->user = User::find(TestDatabaseSeeder::TESTENV_USER_ID);

    }

    /**
     * Test only authenticated user can access to stocks view
     * 
     * @test
     * @return void
     */
    public function stocksRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/stocks');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }

    /**
     * Test stock index method and view
     * 
     * @test
     * @return void
     */
    public function stockIndexIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/stocks');

        $response->assertViewIs('stocks')->assertStatus(200);
    }

    /**
     * Test stock create method and view 
     *
     * @test
     * @return void
     */
    public function stockCreateIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/stocks/create');

        $response
            ->assertViewIs('stocks')
            ->assertViewHas('is_creating')
            ->assertViewHas('products')
            ->assertViewHas('commands_products')
            ->assertStatus(200);
    }

    /**
     * Test if Stocks method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly put in stocks
     *  - The product is correctly updated in commands
     *
     * @test
     * @return void
     */
    public function stockStoreIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/stocks/create', [
            'quantity' => 5,
            'useby_date' => '2021-12-30',
            'command_id' => 1,
        ]);

        //Check if the product we just add is added correctly in database
        $stock = Stock::where([
            'id' => 5, //Because there is already 4 in test stock
            'quantity' => 5,
            'useby_date' => '2021-12-30',
            'command_id' => 1,
        ])->exists();
        
        $this->assertTrue($stock);

        //Check if the product related to it in commands has been updated
        $command = Command::where([
            'id' => 1,
            'quantity' => 25, //Because there is already two stocks products with quantity = 10 for this product
            'alert_stock' => 20,
            'must_buy' => 0, //must_buy passed to false because now quantity > alert_stock
        ])->exists();

        $this->assertTrue($command);

        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas([
                'success' => 'New product added to stocks',
            ]);
    }

    /**
     * Test stock edit method and view 
     *
     * @test
     * @return void
     */
    public function stockEditIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/stocks/modify/{id}');

        $response
            ->assertViewIs('stocks')
            ->assertViewHas('products')
            ->assertViewHas('modifying_product_id')
            ->assertStatus(200);
    }

    /**
     * Test if Stocks method "Update" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly updated in stocks
     *  - The product is correctly updated in commands
     *
     * @test
     * @return void
     */
    public function stockUpdateIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/stocks/modify', [
            'id' => 1,
            'command_id' => 1,
            'useby_date' => '2021-12-30',
            'quantity' => 5,
        ]);

        //Check if the product we just update has been updated correctly
        $stock = Stock::where([
            'id' => 1,
            'quantity' => 5,
            'useby_date' => '2021-12-30',
            'command_id' => 1,
            'user_id' => $this->user->id,
        ])->exists();
        
        $this->assertTrue($stock);

        //Check if the product related to it in commands has been updated
        $command = Command::where([
            'id' => 1,
            'quantity' => 15,
            'must_buy' => 1,
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($command);

        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas([
                'success' => 'Product modified !',
            ]);
    }

    /**
     * Test stock delete-confirmation method and view 
     *
     * @test
     * @return void
     */
    public function stockDeleteConfirmIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/stock-delete-confirmation');

        //Should return an error message and redirect to stocks, because no products are selected
        $response
            ->assertRedirect('/stocks')
            ->assertSessionHas('message', 'You need to select products first !')
            ->assertStatus(302);
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
        //Test destroying products 1 and 2 in stocks
        $response = $this->actingAs($this->user)->post('/stocks/delete', [
            'delete_1' => 1,
            'delete_2' => 2,
        ]);

        //Check if the products we delete are not there anymore
        $stock = Stock::find(1);
        $stock2 = Stock::find(2);
        
        $this->assertTrue(empty($stock) && empty($stock2));

        //Check if the product related to it in commands was updated
        $command = Command::where([
            'id' => 1,
            'quantity' => 0,
            'alert_stock' => 20,
            'must_buy' => 1,
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($command);

        $response
            ->assertStatus(200)
            ->assertSessionHas([
                'success' => '2 entries deleted !',
            ]);
    }
}
