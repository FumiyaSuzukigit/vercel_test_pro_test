<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InformMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $date;
    public $time;
    public $shop;
    public $hc;
    public $recommendation;

    /**
     * Create a new message instance.
     */
    public function __construct($name,$date,$time,$shop,$hc,$recommendation)
    {
        $this->name=$name;
        $this->date=$date;
        $this->time=$time;
        $this->shop=$shop;
        $this->hc=$hc;
        $this->recommendation=$recommendation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '予約のお知らせ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.inform',);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
