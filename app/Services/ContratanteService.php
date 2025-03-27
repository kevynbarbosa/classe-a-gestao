<?php

namespace App\Services;

use App\Models\Contratante;
use App\Models\Cidade;
use Exception;

class ContratanteService
{
    public function obterOuCriarContratante($request)
    {
        $contratante = $this->buscarContratante($request);

        if ($contratante) {
            if ($request->tipo_pessoa != 'prefeitura') {
                $contratante->update($request->except($this->getContratanteExceptFields()));
            }
        } else {
            $contratante = $this->criarContratante($request);
        }

        if (!$contratante) {
            throw new Exception('Erro ao salvar contratante');
        }

        return $contratante;
    }

    private function buscarContratante($request)
    {
        if ($request->tipo_pessoa == 'prefeitura') {
            return Contratante::where('tipo_pessoa', 'prefeitura')
                ->where('cidade_id', $request->evento_cidade_id)
                ->first();
        }

        return Contratante::where('cpf_cnpj', $request->cpf_cnpj)->first();
    }

    private function criarContratante($request)
    {
        $data = $request->except($this->getContratanteExceptFields());
        $data['tipo_pessoa'] = $this->definirTipoPessoa($request);

        if ($request->tipo_pessoa == 'prefeitura') {
            $cidade = Cidade::find($request->evento_cidade_id);
            $data['nome_completo'] = 'Prefeitura de ' . $cidade->nome . '/' . $cidade->uf_codigo;
            $data['cidade_id'] = $request->evento_cidade_id;
        }

        return Contratante::create($data);
    }

    private function definirTipoPessoa($request)
    {
        return $request->tipo_pessoa == 'prefeitura' ? 'prefeitura' : ($request->cpf_cnpj > 11 ? 'pj' : 'pf');
    }

    private function getContratanteExceptFields()
    {
        return ['artista_pretendido', 'valor_combinado', 'evento_cidade_id', 'evento_recinto', 'evento_duracao', 'evento_data_hora', 'observacoes'];
    }
}
