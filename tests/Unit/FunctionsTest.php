<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Carbon;

class FunctionsTest extends TestCase
{
    /**
     * Test ProductExpire method return '-warning' as a class sufix
     *
     * @return void
     */
    public function testProductExpireReturnWarning()
    {
        //Because we have an old date, the function should return warning
        $date = Carbon::now()->add(-10, 'day')->format('Y-m-d');

        $response = FrontController::checkProductExpire($date);

        $this->assertTrue($response == '-warning');
    }

    /**
     * Test ProductExpire method return '-message' as a class sufix
     *
     * @return void
     */
    public function testProductExpireReturnMessage()
    {
        //Because we are only 9 days in future from now, the function should return message
        $date = Carbon::now()->add(9, 'day')->format('Y-m-d');

        $response = FrontController::checkProductExpire($date);

        $this->assertTrue($response == '-message');
    }

    /**
     * Test ProductExpire method return '-success' as a class sufix
     *
     * @return void
     */
    public function testProductExpireReturnSuccess()
    {
        //Because we are more than 10 days in future from now, the function should return message
        $date = Carbon::now()->add(11, 'day')->format('Y-m-d');

        $response = FrontController::checkProductExpire($date);

        $this->assertTrue($response == '-success');
    }
}
