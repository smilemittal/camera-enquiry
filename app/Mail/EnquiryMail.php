<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $products;
    protected $quantities;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $quantities)
    {
        $this->products = $products;
        $this->quantities = $quantities;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('enquiries.partials.pdf')->with(['products' => $this->products, 'quantities' => $this->quantities]);
    }
}
