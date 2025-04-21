<?php

namespace App\Mail;

use App\Models\Reparacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReparacionListaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reparacion;

    public function __construct(Reparacion $reparacion)
    {
        $this->reparacion = $reparacion;
    }

    public function build()
    {
        return $this->subject('Tu reparación está lista – TavoCell 504')
                    ->view('emails.reparacion_lista');
    }
}
