<h1>Contratação para o evento {{ $evento->titulo }}</h1>
<p>Olá, {{ $evento->contratante->nome_completo }}.</p>
<p>Você foi convidado para contratar o evento com {{ $evento->artista->nome }}, que ser realizado em {{ $evento->data_hora->format('d/m/Y H:i') }} no local <b>{{ $evento->recinto }}</b>.</p>
<p>Para confirmar sua participação, clique no link abaixo.</p>
<p><a href="{{ route('evento-workflow.contratante-formulario', ['evento' => $evento->token_formulario]) }}">Confirmar participação</a></p>
<p>Atenciosamente,<br>{{ config('app.name') }}</p>

<!-- <img src="https://openpix.github.io/pix-logo.png?cb={{ microtime() }}" alt="" style="display: none;"/> -->
