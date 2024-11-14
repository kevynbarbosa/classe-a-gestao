<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;
use App\Traits\HasOptionsEnum;

enum EventoStatusEnum: string
{
    use AttributableEnum, HasOptionsEnum;

    #[Description('Formulário pendente de envio')]
    case FORMULARIO_PENDENTE = 'formulario_pendente';

    #[Description('Formulário enviado, aguardando preenchimento')]
    case FORMULARIO_ENVIADO = 'formulario_enviado';

    #[Description('Pendente de proposta')]
    case PENDENTE_PROPOSTA = 'pendente_proposta';

    #[Description('Proposta enviada')]
    case PROPOSTA_ENVIADA = 'proposta_enviada';

    #[Description('Pendente de NF')]
    case PENDENTE_NF = 'pendente_nf';

    #[Description('Concluído')]
    case CONCLUIDO = 'concluido';

    #[Description('Cancelado')]
    case CANCELADO = 'cancelado';
}
