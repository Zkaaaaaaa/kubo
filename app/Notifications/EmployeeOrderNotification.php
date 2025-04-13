<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EmployeeOrderNotification extends Notification implements ShouldQueue
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
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
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
                ->action('Lihat Pesanan', url('/admin/orders'))
                ->line('Segera proses pesanan ini!');
        } catch (\Exception $e) {
            Log::error('Failed to create mail message', [
                'error' => $e->getMessage(),
                'order_id' => $this->order->id,
                'user_id' => $this->user->id
            ]);
            throw $e;
        }
    }
} 