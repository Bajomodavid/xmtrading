<?php

namespace Tests\Unit;

use Tests\TestCase;

class QuotesHistoryTest extends TestCase
{
    public function test_filter_history_response()
    {
        $data = [
            'symbol' => 'AAIT',
            'start' => '09/01/2016',
            'end' => '09/30/2022',
            'email' => 'bajomodavid@gmail.com',
        ];
        $response =$this->post(route('quotes.fetch'), $data);
        $response->assertStatus(200);
    }
}
