<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class FormularioVentaUsuarioMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;
    public $numeroDeImagenes;

    /**
     * Create a new message instance.
     */
    public function __construct(Request $request, $numeroDeImagenes)
    {
        $this->datos = $request;
        $this->numeroDeImagenes = $numeroDeImagenes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Datos enviado a Villablancars',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.formulario_venta_usuario',
            with: ([
                'nombre' => $this->datos->nombre,
                'email' => $this->datos->email,
                'marca' => $this->datos->marca,
                'carroceria' => $this->datos->carroceria,
                'modelo' => $this->datos->modelo,
                'anio' => $this->datos->anio,
                'color' => $this->datos->color,
                'cambio' => $this->datos->cambio,
                'kilometros' => $this->datos->kilometros,
                'autonomia' => $this->datos->autonomia,
                'potencia' => $this->datos->potencia,
                'descripcion' => $this->datos->descripcion,
                'numeroDeImagenes' => $this->numeroDeImagenes
            ])
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
