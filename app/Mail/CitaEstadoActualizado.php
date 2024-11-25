<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Cita;

class CitaEstadoActualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;
    public $nuevoEstado;

    /**
     * Create a new message instance.
     */
    public function __construct(Cita $cita, string $nuevoEstado)
    {
        $this->cita = $cita;
        $this->nuevoEstado = $nuevoEstado;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tu cita ha sido " . ucfirst($this->nuevoEstado),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cita_estado_actualizado',
            with: [
                'cita' => $this->cita,
                'nuevoEstado' => $this->nuevoEstado,
            ]
        );
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
