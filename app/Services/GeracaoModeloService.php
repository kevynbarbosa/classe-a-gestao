<?php

namespace App\Services;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class GeracaoModeloService
{

    private array $dados;

    public function __construct(public Evento $evento)
    {
        $this->dados = $this->getDados();
    }

    function substituirTokensNoDocx($modeloDocx, $dados, $pathDocx)
    {
        // Carregar o template do Word
        $templateProcessor = new TemplateProcessor($modeloDocx);

        // Substituir os tokens no arquivo Word
        foreach ($dados as $token => $valor) {
            $templateProcessor->setValue($token, htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'));
        }

        if ($this->evento->artista->logo_path) {
            $templateProcessor->setImageValue('IMAGEM', [
                'path' => $this->evento->artista->logo_path, // Caminho da imagem
                // 'width' => 200, // Largura em pixels
                // 'height' => 150, // Altura em pixels
                // 'ratio' => true // Mantém a proporção da imagem
            ]);
        }

        // Salvar o arquivo Word com os dados substituídos
        $templateProcessor->saveAs($pathDocx);
    }

    private function alterarCores($pathDocx, $corBase = 'fffac2')
    {
        $artista = $this->evento->artista;
        $newColor = $artista->color ? str_replace("#", "", $artista->color) : $corBase;

        $zip = new \ZipArchive();
        $zip->open($pathDocx);

        // Documento principal
        $content = $zip->getFromName('word/document.xml');
        $content = str_replace("#$corBase", "#$newColor", $content);
        $content = str_replace(strtolower($corBase), strtolower($newColor), $content);
        $content = str_replace(strtoupper($corBase), strtoupper($newColor), $content);

        // dd($newColor, $corBase);

        $this->alterarCorSecao($zip, 'document', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'footer1', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'footer2', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'footer3', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'header1', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'header2', $corBase, $newColor);
        $this->alterarCorSecao($zip, 'header3', $corBase, $newColor);

        $zip->close();
    }

    private function alterarCorSecao($zip, $secao, $corBase, $newColor)
    {
        $nomeArquivo = "word/$secao.xml";

        $content = $zip->getFromName($nomeArquivo);
        if ($content) {
            $content = str_replace("#$corBase", "#$newColor", $content);
            $content = str_replace(strtolower($corBase), strtolower($newColor), $content);
            $content = str_replace(strtoupper($corBase), strtoupper($newColor), $content);

            $zip->deleteName($nomeArquivo);
            $zip->addFromString($nomeArquivo, $content);
        }
    }

    private function converteEmPdf($pathDocx, $pathPdf)
    {
        // dd($pathDocx);
        $outputDir = $pathPdf;
        $result = null;
        $output = null;
        exec("libreoffice --headless --invisible --norestore --convert-to pdf $pathDocx --outdir $outputDir", $output, $result);
        // dd($output, $result, $pathDocx, $outputDir, "libreoffice --headless --invisible --norestore --convert-to pdf $pathDocx --outdir $outputDir");

        if ($result !== 0) {
            throw new \Exception("Erro ao converter o arquivo Word para PDF.");
        }
    }


    function gerarProposta()
    {
        $modeloDocx = resource_path('modelos_proposta/MODELO_PROPOSTA.docx');
        $pathDocx = storage_path('app/public/eventos/' . $this->evento->id . '/proposta.docx');

        $dados = $this->dados;
        $this->validateDados();

        Storage::makeDirectory('public/eventos/' . $this->evento->id);

        // Proposta
        $this->substituirTokensNoDocx($modeloDocx, $dados, $pathDocx);
        $this->alterarCores($pathDocx);
        $this->converteEmPdf($pathDocx, storage_path('app/public/eventos/' . $this->evento->id));

        // Declarações
        $this->substituirTokensNoDocx(resource_path('modelos_proposta/DECLARACOES.docx'), $dados, storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes.docx'));
        $this->converteEmPdf(storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes.docx'), storage_path('app/public/eventos/' . $this->evento->id));

        // Declarações econômicas
        $this->substituirTokensNoDocx(resource_path('modelos_proposta/DECLARACOES_ECONOMICAS.docx'), $dados, storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes_economicas.docx'));
        $this->converteEmPdf(storage_path('app/public/eventos/' . $this->evento->id . '/declaracoes_economicas.docx'), storage_path('app/public/eventos/' . $this->evento->id));

        // Contrato
        $this->gerarContrato();
    }

    public function gerarContrato()
    {
        if ($this->evento->contratante->tipo_pessoa == 'prefeitura') return;

        $pathContratoDocx = storage_path('app/public/eventos/' . $this->evento->id . '/contrato.docx');

        $this->substituirTokensNoDocx(resource_path('modelos_proposta/CONTRATO.docx'), $this->dados, $pathContratoDocx);
        $this->alterarCores($pathContratoDocx, '31521a');
        $this->converteEmPdf($pathContratoDocx, storage_path('app/public/eventos/' . $this->evento->id));
    }

    private function getDados()
    {
        $artista = $this->evento->artista;
        $contratante = $this->evento->contratante;

        $dados = [
            'CONTRATANTE_NOME' => $this->evento->contratante->nome_completo,
            'CONTRATANTE_CNPJ' => $contratante->cpf_cnpj,
            'CONTRATANTE_ENDERECO' => $contratante->endereco,
            'CONTRATANTE_NUMERO' => $contratante->numero,
            'CONTRATANTE_COMPLEMENTO' => $contratante->complemento,
            'CONTRATANTE_BAIRRO' => $contratante->bairro,
            'CONTRATANTE_CIDADE' => $contratante->cidade->nome,
            'CONTRATANTE_ESTADO' => $contratante->cidade->uf_codigo,
            'CONTRATANTE_CEP' => $contratante->cep,
            'CONTRATANTE_EMAIL' => $contratante->email,
            'CONTRATANTE_REPRESENTANTE_LEGAL_NOME' => $contratante->representante_legal_nome,
            'CONTRATANTE_REPRESENTANTE_LEGAL_CPF' => $contratante->representante_legal_cpf,
            'CONTRATANTE_REPRESENTANTE_LEGAL_RG' => $contratante->representante_legal_rg,
            'CONTRATANTE_REPRESENTANTE_LEGAL_ENDERECO' => $contratante->representante_legal_endereco,
            'CONTRATANTE_REPRESENTANTE_LEGAL_NUMERO' => $contratante->representante_legal_numero,
            'CONTRATANTE_REPRESENTANTE_LEGAL_COMPLEMENTO' => $contratante->representante_legal_complemento,
            'CONTRATANTE_REPRESENTANTE_LEGAL_CEP' => $contratante->representante_legal_cep,
            'CONTRATANTE_REPRESENTANTE_LEGAL_CIDADE' => $contratante->representanteLegalCidade->nome ?? "",
            'CONTRATANTE_REPRESENTANTE_LEGAL_ESTADO' => $contratante->representanteLegalCidade->uf_codigo  ?? "",
            'CONTRATANTE_REPRESENTANTE_LEGAL_TELEFONE' => $contratante->representante_legal_telefone,
            'CONTRATANTE_REPRESENTANTE_LEGAL_ESTADO_CIVIL' => $artista->representante_legal_estado_civil,
            'CONTRATANTE_REPRESENTANTE_LEGAL_NACIONALIDADE' => $this->formatarNacionalidade($artista->representante_legal_sexo),
            'CONTRATANTE_REPRESENTANTE_LEGAL_SEXO' => $artista->representante_legal_sexo,


            'ARTISTA_NOME' => $artista->nome,
            'ARTISTA_RAZAO_SOCIAL' => $artista->razao_social,
            'ARTISTA_CNPJ' => $artista->cnpj,
            'ARTISTA_ENDERECO' => $artista->endereco,
            'ARTISTA_NUMERO' => $artista->numero,
            'ARTISTA_COMPLEMENTO' => $artista->complemento,
            'ARTISTA_BAIRRO' => $artista->bairro,
            'ARTISTA_CIDADE' => $artista->cidade->nome,
            'ARTISTA_CEP' => $artista->cep,
            'ARTISTA_TELEFONE' => $artista->telefone,
            'ARTISTA_EMAIL' => $artista->email,
            'ARTISTA_REPRESENTANTE_LEGAL_NOME' => $artista->representante_legal_nome,
            'ARTISTA_REPRESENTANTE_LEGAL_NOME' => $artista->representante_legal_nome,
            'ARTISTA_REPRESENTANTE_LEGAL_CPF' => $artista->representante_legal_cpf,
            'ARTISTA_REPRESENTANTE_LEGAL_RG' => $artista->representante_legal_rg,
            'ARTISTA_REPRESENTANTE_LEGAL_ENDERECO' => $artista->representante_legal_endereco,
            'ARTISTA_REPRESENTANTE_LEGAL_NUMERO' => $artista->representante_legal_numero,
            'ARTISTA_REPRESENTANTE_LEGAL_COMPLEMENTO' => $artista->representante_legal_complemento,
            'ARTISTA_REPRESENTANTE_LEGAL_CEP' => $artista->representante_legal_cep,
            'ARTISTA_REPRESENTANTE_LEGAL_CIDADE' => $artista->representanteLegalCidade->nome,
            'ARTISTA_REPRESENTANTE_LEGAL_ESTADO' => $artista->representanteLegalCidade->uf_codigo,
            'ARTISTA_REPRESENTANTE_LEGAL_TELEFONE' => $artista->representante_legal_telefone,
            'ARTISTA_REPRESENTANTE_LEGAL_ESTADO_CIVIL' => $artista->representante_legal_estado_civil,
            'ARTISTA_REPRESENTANTE_LEGAL_NACIONALIDADE' => $this->formatarNacionalidade($artista->representante_legal_sexo),
            'ARTISTA_REPRESENTANTE_LEGAL_SEXO' => $artista->representante_legal_sexo,

            'EVENTO_CIDADE' => $this->evento->cidade->nome,
            'EVENTO_DURACAO' => $this->evento->duracao,
            'EVENTO_DATA' => Carbon::parse($this->evento->data_hora)->format('d/m/Y'),
            'EVENTO_RECINTO' => $this->evento->recinto,
            'EVENTO_VALOR' => number_format($this->evento->valor, 2, ',', '.'),
            'EVENTO_VALOR_EXTENSO' => MonetaryService::numberToExt($this->evento->valor),

            'PROPOSTA_DATA_GERACAO' => date('d/m/Y'),

            'RATEIO_1' => MonetaryService::formatMoney($this->evento->valor * 0.422),
            'RATEIO_2' => MonetaryService::formatMoney($this->evento->valor * 0.15),
            'RATEIO_3' => MonetaryService::formatMoney($this->evento->valor * 0.2),
            'RATEIO_4' => MonetaryService::formatMoney($this->evento->valor * 0.06),
            'RATEIO_5' => MonetaryService::formatMoney($this->evento->valor * 0.058),

            'TRATAMENTO_DECLARACAO' => 'Aos cuidados de ' . $this->evento->contratante->nome_completo,

            'PAGAMENTOS' => $this->gerarPagamentos(),
        ];

        foreach ($dados as $key => $value) {
            if (strpos($key, "ARTISTA_REPRESENTANTE_LEGAL") !== false) {
                $novaChave = str_replace("ARTISTA_REPRESENTANTE_LEGAL", "AL", $key);
                $dados[$novaChave] = $value;
            } else if (strpos($key, "CONTRATANTE_REPRESENTANTE_LEGAL") !== false) {
                $novaChave = str_replace("CONTRATANTE_REPRESENTANTE_LEGAL", "CL", $key);
                $dados[$novaChave] = $value;
            } else if (strpos($key, "CONTRATANTE_") !== false) {
                $novaChave = str_replace("CONTRATANTE_", "C_", $key);
                $dados[$novaChave] = $value;
            }
        }

        // dd($dados);
        return $dados;
    }

    private function validateDados()
    {
        $nullables = [
            'CONTRATANTE_REPRESENTANTE_LEGAL_COMPLEMENTO',
            'ARTISTA_REPRESENTANTE_LEGAL_COMPLEMENTO',
        ];

        $contratante = $this->evento->contratante;
        if ($contratante->tipo_pessoa == 'prefeitura') {
            $nullables[] = 'CONTRATANTE_CNPJ';
            $nullables[] = 'CONTRATANTE_ENDERECO';
            $nullables[] = 'CONTRATANTE_NUMERO';
            $nullables[] = 'CONTRATANTE_COMPLEMENTO';
            $nullables[] = 'CONTRATANTE_BAIRRO';
            $nullables[] = 'CONTRATANTE_CEP';
            $nullables[] = 'CONTRATANTE_EMAIL';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_NUMERO';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_CEP';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_ENDERECO';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_NOME';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_CPF';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_RG';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_CIDADE';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_ESTADO';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_TELEFONE';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_ESTADO_CIVIL';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_NACIONALIDADE';
            $nullables[] = 'CONTRATANTE_REPRESENTANTE_LEGAL_SEXO';
        }

        foreach ($nullables as $value) {
            if (strpos($value, "ARTISTA_REPRESENTANTE_LEGAL") !== false) {
                $nullables[] = str_replace("ARTISTA_REPRESENTANTE_LEGAL", "AL", $value);
            } else if (strpos($value, "CONTRATANTE_REPRESENTANTE_LEGAL") !== false) {
                $nullables[] = str_replace("CONTRATANTE_REPRESENTANTE_LEGAL", "CL", $value);
            } else if (strpos($value, "CONTRATANTE_") !== false) {
                $nullables[] = str_replace("CONTRATANTE_", "C_", $value);
            }
        }

        // dd($nullables);

        foreach ($this->dados as $key => $value) {
            if (is_null($value) && !in_array($key, $nullables)) {
                throw new \Exception("O valor para o token '$key' nao pode ser nulo.");
            }
        }
    }

    private function formatarNacionalidade($sexo): string | null
    {
        if ($sexo == 'M') {
            return 'brasileiro';
        } elseif ($sexo == 'F') {
            return 'brasileira';
        } else {
            return null;
        }
    }

    private function gerarPagamentos()
    {
        $pagamentos = $this->evento->pagamentos;

        $dados = [];
        foreach ($pagamentos as $pagamento) {
            $data_pagamento = Carbon::parse($pagamento->data_pagamento)->format('d/m/Y');
            $dados[] = "R$ " . MonetaryService::formatMoney($pagamento->valor) . " (" . MonetaryService::numberToExt($pagamento->valor) . ") - " . "em " . $data_pagamento;
        }

        return implode("\n", $dados);
    }
}
