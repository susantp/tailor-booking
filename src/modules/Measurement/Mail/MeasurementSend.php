<?php

namespace Modules\Measurement\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeasurementSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(sprintf('New Measurement From %s %s', $this->data['first_name'], $this->data['last_name']))
            ->from('noreply@scottfergusonformalwear.com.au')
            ->view('measurement::send');
    }
}