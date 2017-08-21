<?php

namespace shopTest\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductImport extends Mailable
{
    use Queueable, SerializesModels;
    protected $information;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($information)
    {
        $this->information = $information;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.productImport')->with(['information' => $this->information]);
    }
}
