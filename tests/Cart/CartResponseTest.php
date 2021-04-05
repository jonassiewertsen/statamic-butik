<?php

namespace Tests\Cart;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Http\Responses\CartResponse;
use Tests\TestCase;

class CartResponseTest extends TestCase
{
    protected ProductRepository $product;
    protected string $slug;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
        $this->slug = $this->product->slug;
    }

    /** @test */
    public function a_card_response_can_be_successfull()
    {
        $response = CartResponse::success();

        $this->assertTrue($response::$success);
    }

    /** @test */
    public function it_can_contain_a_success_message()
    {
        $message = 'the item has been added';
        $response = CartResponse::success($message);

        $this->assertEquals($message, $response::$message);
    }

    /** @test */
    public function a_card_response_can_be_failed()
    {
        $response = CartResponse::failed();

        $this->assertFalse($response::$success);
    }

    /** @test */
    public function it_can_contain_a_message_if_failed()
    {
        $message = 'the item could not be added';
        $response = CartResponse::failed($message);

        $this->assertEquals($message, $response::$message);
    }
}
