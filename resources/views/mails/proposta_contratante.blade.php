@extends('mails.mail_layout')

@section('content')
<h1>Contratação para o evento {{ $evento->titulo }}</h1>
<p>Olá, {{ $evento->contratante->nome_completo }}.</p>
<p>Segue em anexo proposta de contratação para o evento com {{ $evento->artista->nome }}, a ser realizado em {{ $evento->data_hora->format('d/m/Y H:i') }} no local <b>{{ $evento->recinto }}</b>.</p>
<p>Atenciosamente,<br>{{ config('app.name') }}</p>
@endsection

<!-- <img src="https://openpix.github.io/pix-logo.png?cb={{ microtime() }}" alt="" style="display: none;"/> -->
