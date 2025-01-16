<?php

namespace App\Enums;

use App\Attributes\EnumDescription;
use App\Attributes\EnumSeverityColor;
use App\Traits\AttributableEnum;
use App\Traits\HasOptionsEnum;

enum EventoStatusEnum: string
{
    use AttributableEnum, HasOptionsEnum;

    #[EnumDescription('Formulário pendente de envio')]
    #[EnumSeverityColor('warning')]
    case FORMULARIO_PENDENTE = 'formulario_pendente';

    #[EnumDescription('Formulário enviado, aguardando preenchimento')]
    #[EnumSeverityColor('info')]
    case FORMULARIO_ENVIADO = 'formulario_enviado';

    #[EnumDescription('Pendente de proposta')]
    #[EnumSeverityColor('warning')]
    case PENDENTE_PROPOSTA = 'pendente_proposta';

    #[EnumDescription('Proposta gerada')]
    #[EnumSeverityColor('info')]
    case PROPOSTA_GERADA = 'proposta_gerada';

    #[EnumDescription('Proposta enviada')]
    #[EnumSeverityColor('info')]
    case PROPOSTA_ENVIADA = 'proposta_enviada';

    #[EnumDescription('Pendente de NF')]
    #[EnumSeverityColor('warning')]
    case PENDENTE_NF = 'pendente_nf';

    #[EnumDescription('Concluído')]
    #[EnumSeverityColor('success')]
    case CONCLUIDO = 'concluido';

    #[EnumDescription('Cancelado')]
    #[EnumSeverityColor('danger')]
    case CANCELADO = 'cancelado';
}
