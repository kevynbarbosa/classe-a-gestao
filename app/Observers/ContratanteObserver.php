<?php

namespace App\Observers;

use App\Models\Contratante;

class ContratanteObserver
{
    public function creating(Contratante $contratante): void
    {
        $contratante->representante_legal_nacionalidade = $this->formatarNacionalidade($contratante);
    }

    public function updating(Contratante $contratante): void
    {
        if ($contratante->isDirty('representante_legal_sexo')) {
            $contratante->representante_legal_nacionalidade = $this->formatarNacionalidade($contratante);
        }
    }

    private function formatarNacionalidade(Contratante $contratante): string
    {
        if ($contratante->representante_legal_sexo == 'M') {
            return 'brasileiro';
        } elseif ($contratante->representante_legal_sexo == 'F') {
            return 'brasileira';
        } else {
            return '';
        }
    }
}
