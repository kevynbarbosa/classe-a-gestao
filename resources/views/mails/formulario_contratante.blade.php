@extends('mails.mail_layout')

@section('content')
<h1>Contratação para o evento {{ $evento->titulo }}</h1>
<p>Olá, {{ $evento->contratante->nome_completo ?? $nome }}.</p>
<p>Para prosseguir com a contratação do evento, por favor, clique no link abaixo.</p>
<p style="color: white; background-color: #4B5563; padding: 16px; border-radius: 10px;text-align: center;">
    <a style="color: white"  href="{{ route('evento-workflow.contratante-formulario', ['evento' => $evento->token_formulario]) }}">Confirmar participação</a>
</p>
<p>Atenciosamente,<br>{{ config('app.name') }}</p>
@endsection

<!-- <img src="https://openpix.github.io/pix-logo.png?cb={{ microtime() }}" alt="" style="display: none;"/> -->
