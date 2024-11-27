<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SendMessageRateLimitTest extends TestCase
{
    use RefreshDatabase;
  

    public function test_send_message_allows_requests_within_limit()
    {
        $data=[
            'email'=>'sajt@32.gmail.com',
            'message'=>'minden nagyon jo!'
        ];
        // Az IP-cím példája
        $ip = '192.168.1.1';

        // Simuláljunk 3 kérést, amelyeknek engedélyezettnek kell lenniük
        foreach (range(1, 3) as $i) {
            $response = $this->postJson(route('sendMessage',$data), [], ['REMOTE_ADDR' => $ip]);
            $response->assertStatus(200); // Válaszkód: OK
        }
    }

    public function test_send_message_blocks_requests_exceeding_limit()
    {
        // Az IP-cím példája
        $data=[
            'email'=>'sajt@32.gmail.com',
            'message'=>'minden nagyon jo!'
        ];
        $ip = '192.168.1.1';

        // Simuláljuk 4 kérést: az első háromnak át kell mennie, a negyedik blokkolva lesz
        foreach (range(1, 4) as $i) {
            $response = $this->postJson(route('sendMessage',$data), [], ['REMOTE_ADDR' => $ip]);

            if ($i <= 3) {
                $response->assertStatus(200); // Az első három sikeres
            } else {
                $response->assertStatus(429); // A negyedik túl sok kérés
            }
        }
    }

    public function test_rate_limit_blocks()
    {
        // Az IP-cím példája
        $ip = '192.168.1.1';
        $data=[
            'email'=>'sajt@32.gmail.com',
            'message'=>'minden nagyon jo!'
        ];

        // Simuláljuk 3 kérést, amelyek engedélyezve vannak
        foreach (range(1, 3) as $i) {
            $response = $this->postJson(route('sendMessage',$data), [], ['REMOTE_ADDR' => $ip]);
            $response->assertStatus(200);
        }

        // Egy újabb kérésnek most engedélyezettnek kell lennie
        $response = $this->postJson(route('sendMessage',$data), [], ['REMOTE_ADDR' => $ip]);
        $response->assertStatus(429);
    }
}
