<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DownloadBoleto
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $boleto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($boleto)
    {
        $this->boleto = $boleto;
    }


    public function boleto()
    {
        return $this->boleto;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
