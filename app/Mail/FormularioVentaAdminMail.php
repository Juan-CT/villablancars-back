<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class FormularioVentaAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;
    public $imagenRutas;
    /**
     * Create a new message instance.
     */
    public function __construct(Request $request, $imagenRutas)
    {
        $this->datos = $request;
        $this->imagenRutas = $imagenRutas;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo formulario de venta de coche',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.formulario_venta_admin',
            with: ([
                'nombre' => $this->datos->nombre,
                'email' => $this->datos->email,
                'marca' => $this->datos->marca ?? 'No proporcionado',
                'carroceria' => $this->datos->carroceria ?? 'No proporcionado',
                'modelo' => $this->datos->modelo ?? 'No proporcionado',
                'anio' => $this->datos->anio ?? 'No proporcionado',
                'color' => $this->datos->color ?? 'No proporcionado',
                'cambio' => $this->datos->cambio ?? 'No proporcionado',
                'kilometros' => $this->datos->kilometros ?? 'No proporcionado',
                'autonomia' => $this->datos->autonomia ?? 'No proporcionado',
                'potencia' => $this->datos->potencia ?? 'No proporcionado',
                'descripcion' => $this->datos->descripcion ?? 'No proporcionado',
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
        $attachments = [];

        foreach ($this->imagenRutas as $ruta) {
            $attachments[] = Attachment::fromPath($ruta)
                ->as(basename($ruta))
                ->withMime(mime_content_type($ruta));
        }

        return $attachments;
    }
}
