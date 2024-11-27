<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     /** @test */
    public function it_stores_messages(){
        $data=[
            'email'=>'sajt@32.gmail.com',
            'message'=>'minden nagyon jo!'
        ];

        $response = $this->postJson('/api/message',$data);


        $response->assertStatus(200);
        $this->assertDatabaseHas('messages', $data);
    }

     /** @test */
     public function it_fails_when_email_is_missing(){
        $data=[
            'message'=>'minden nagyon jo!'
        ];

        $response = $this->postJson('/api/message',$data);


        $response->assertStatus(422);
        $this->assertDatabaseHas('messages', $data);
    }

     /** @test */
     public function it_fails_when_message_is_missing(){
        $data=[
            'email'=>'sajt@32.gmail.com',
            
        ];

        $response = $this->postJson('/api/message',$data);


        $response->assertStatus(422);
        $this->assertDatabaseHas('messages', $data);
    }
}
