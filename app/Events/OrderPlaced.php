<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $admins = \App\Models\User::where('is_admin', true)->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title("Order #{$order->order_number}")
                ->icon('heroicon-o-shopping-cart')
                ->body("Total: ₱{$order->total_price}")
                ->actions([
                    Action::make('view')
                        ->label('View Order')
                        ->url(route('filament.admin.resources.orders.view', ['record' => $order->id])),
                ])
                ->sendToDatabase($admin);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('orders');
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_price' => $this->order->total_price,
            'status' => $this->order->status,
        ];
    }
    public function broadcastAs()
    {
        return 'order.placed';
    }
}
