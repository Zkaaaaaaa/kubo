<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('new-order');
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'order_token' => $this->order->token,
            'message' => 'Pesanan baru dari ' . $this->order->user->name,
            'time' => now(),
            'user_name' => $this->order->user->name,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'link' => '/employee/orders'
        ];
    }
} 