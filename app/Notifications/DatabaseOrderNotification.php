<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DatabaseOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $user;

    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_token' => $this->order->token,
            'user_name' => $this->user->name,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'message' => 'Pesanan baru dari ' . $this->user->name,
            'link' => '/employee/orders'
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pesanan Baru - ' . config('app.name'))
            ->greeting('Halo Admin!')
            ->line('Ada pesanan baru yang perlu diproses:')
            ->line('Detail Pesanan:')
            ->line('Nomor Pesanan: ' . $this->order->token)
            ->line('Pelanggan: ' . $this->user->name)
            ->line('Email Pelanggan: ' . $this->user->email)
            ->line('Total: Rp ' . number_format($this->order->total, 0, ',', '.'))
            ->line('Status: ' . ucfirst($this->order->status))
            ->action('Lihat Pesanan', url('/employee/orders'))
            ->line('Segera proses pesanan ini!');
    }
} 