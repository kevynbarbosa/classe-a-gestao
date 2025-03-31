<?php

namespace App\Observers;

use App\Models\Artista;

class ArtistaObserver
{
    public function creating(Artista $artista): void
    {
        $artista->representante_legal_nacionalidade = $this->formatarNacionalidade($artista);
    }

    public function updating(Artista $artista): void
    {
        if ($artista->isDirty('representante_legal_sexo')) {
            $artista->representante_legal_nacionalidade = $this->formatarNacionalidade($artista);
        }
    }

    private function formatarNacionalidade(Artista $artista): string
    {
        if ($artista->representante_legal_sexo == 'M') {
            return 'brasileiro';
        } elseif ($artista->representante_legal_sexo == 'F') {
            return 'brasileira';
        } else {
            return '';
        }
    }
}
