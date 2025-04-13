<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_token' => $this->order->token,
            'user_name' => $this->order->user->name,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'message' => 'Pesanan baru dari ' . $this->order->user->name,
            'link' => '/employee/orders',
            'type' => 'order'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'order_token' => $this->order->token,
            'user_name' => $this->order->user->name,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'message' => 'Pesanan baru dari ' . $this->order->user->name,
            'link' => '/employee/orders',
            'type' => 'order'
        ]);
    }
} 