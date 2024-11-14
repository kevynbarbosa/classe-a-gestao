<?php

namespace App\Enums;

use App\Attributes\EnumDescription;
use App\Traits\AttributableEnum;
use App\Traits\HasOptionsEnum;

enum EventoStatusEnum: string
{
    use AttributableEnum, HasOptionsEnum;

    #[EnumDescription('Formulário pendente de envio')]
    case FORMULARIO_PENDENTE = 'formulario_pendente';

    #[EnumDescription('Formulário enviado, aguardando preenchimento')]
    case FORMULARIO_ENVIADO = 'formulario_enviado';

    #[EnumDescription('Pendente de proposta')]
    case PENDENTE_PROPOSTA = 'pendente_proposta';

    #[EnumDescription('Proposta enviada')]
    case PROPOSTA_ENVIADA = 'proposta_enviada';

    #[EnumDescription('Pendente de NF')]
    case PENDENTE_NF = 'pendente_nf';

    #[EnumDescription('Concluído')]
    case CONCLUIDO = 'concluido';

    #[EnumDescription('Cancelado')]
    case CANCELADO = 'cancelado';
}
