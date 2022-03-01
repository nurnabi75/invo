<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable 
{
    use Queueable, SerializesModels;
    public $data,$pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data =$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user       = $this->data['user'];
        $invoice    = $this->data['invoice'];
        $client     = $this->data['invoice']->client;
        $invoice_id = $this->data['invoice_id'];

        $pdf        = public_path('storage/invoices/'.$invoice->download_url);

        return $this->markdown('emails.invoice')
            ->to($client->email, $client->name)
            ->subject($invoice_id)
            ->from($user->email, $user->name)
            ->attach($pdf, ['mime' => 'application/pdf']);
    }
}


