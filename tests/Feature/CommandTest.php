<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Tests\TestCase;
use App\Models\Command;
use App\Models\Stock;
use App\Models\User;

class CommandTest extends TestCase
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
     * Test only authenticated user can access to commands view
     * 
     * @test
     * @return void
     */
    public function commandsRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/commands');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }

    /**
     * Test commands index method and view
     * 
     * @test
     * @return void
     */
    public function commandIndexIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/commands');

        $response->assertViewIs('commands')->assertStatus(200);
    }

    /**
     * Test command create method and view 
     *
     * @test
     * @return void
     */
    public function commandCreateIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/commands/create');

        $response
            ->assertViewIs('commands')
            ->assertViewHas('is_creating')
            ->assertViewHas('products')
            ->assertStatus(200);
    }

   /**
     * Test if Commands method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly added in commands
     *
     * @test
     * @return void
     */
    public function commandStoreIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/commands/create', [
            'ingredient' => 'new_ingredient',
            'unit' => 'new_unit',
            'alert_stock' => 5,
        ]);

        //Check if the product has been added (should be the third as there is already two other products)
        $command = Command::where([
            'id' => 3,
            'ingredient' => 'new_ingredient',
            'quantity' => 0,
            'unit' => 'new_unit',
            'alert_stock' => 5,
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($command);

        $response
            ->assertRedirect('/commands')
            ->assertSessionHas([
                'success' => 'Product successfully added !',
            ]);
    }

    /**
     * Test command edit method and view 
     *
     * @test
     * @return void
     */
    public function commandEditIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/commands/modify/1');

        $response
            ->assertViewIs('commands')
            ->assertViewHas('products')
            ->assertViewHas('modifying_product_id')
            ->assertStatus(200);
    }

    /**
     * Test if Commands method "Update" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - The product is correctly updated in commands
     *
     * @test
     * @return void
     */
    public function commandUpdateIfAuth()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->post('/commands/modify', [
            'id' => 1,
            'ingredient' => 'new_ingredient',
            'unit' => 'new_unit',
            'alert_stock' => 5,
        ]);

        //Check if the product has been updated in commands
        $command = Command::where([
            'id' => 1,
            'ingredient' => 'new_ingredient',
            'unit' => 'new_unit',
            'alert_stock' => 5,
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($command);

        $response
            ->assertRedirect('/commands')
            ->assertSessionHas([
                'success' => 'Product modified !',
            ]);
    }

    /**
     * Test command delete-confirmation method and view 
     *
     * @test
     * @return void
     */
    public function commandDeleteConfirmIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/command-delete-confirmation');

        //Should return an error message and redirect to commands, because no products are selected
        $response
            ->assertRedirect('/commands')
            ->assertSessionHas('message', 'You need to select products first !')
            ->assertStatus(302);
    }

    /**
     * Test if Commands method "Destroy" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Return the correct amount of deleted entries
     *  - The product is correctly delete from both commands and stocks
     *
     * @test
     * @return void
     */
    public function commandDestroyIfAuth()
    {
        //test destroying command product 1 (stocks[1] and stocks[2] should also be removed)
        $response = $this->actingAs($this->user)->post('/commands/delete', [
            'delete_1' => 1,
        ]);

        //Check if the products we delete are not there anymore, both in stocks and commands
        $command = Command::find(1);
        $stock = Stock::find(1);
        $stock2 = Stock::find(2);
         
        $this->assertTrue(empty($command));
        $this->assertTrue(empty($stock) && empty($stock2));

        $response
            ->assertStatus(200)
            ->assertSessionHas([
                'success' => '1 entry deleted !',
            ]);
    }
}
