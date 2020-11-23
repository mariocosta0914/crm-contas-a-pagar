<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use Illuminate\Support\Facades\Mail;
use App\Contatos;
use App\Events\EnviarLembrete;
use App\Events\EnviarTitulo;
use App\Filas;
use App\Helpers\Helper;
use App\Mail\SendMailLembrete;
use App\Mail\SendMailTituloNota;
use App\Tratativas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GerarNotaController;
use App\TodosBoletos;

class ClientesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna os Dados Referentes a Um Cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDadosCliente($id_cliente)
    {
        return Clientes::getInformacoesCliente($id_cliente);
    }

    /**
     * Informa a Quantidade de Títulos em Aberto e a Soma dos Valores.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQtdTitulosValor($id_cliente)
    {
        return Clientes::getQtdTitulos($id_cliente);
    }

    /**
     * Informa todos os titulos do cliente 
     *
     * @return \Illuminate\Http\Response
     */
    public function getInforTitutlos($id_cliente)
    {
        return Clientes::getInforTitutlos($id_cliente);
    }

    /* * Salva Os Novos Contatos do Cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function adicionaContatos(Request $request)
    {
        foreach ($request->emails as $email) {
            if ($email['email'] != null) {
                $emails['id_cliente'] = $email['id_cliente'];
                $emails['contato'] = $email['email'];
                $emails['tipo_contato'] = "email";
                Contatos::insertContatos($emails);
            }
        }
        foreach ($request->telefones as $telefone) {
            if ($telefone['telefone'] != null) {
                $telefones['id_cliente'] = $telefone['id_cliente'];
                $telefones['contato'] = $telefone['telefone'];
                $telefones['tipo_contato'] = "telefone";
                $telefones['whatsapp'] = $telefone['whatsapp'];
                Contatos::insertContatos($telefones);
            }
        }
    }

    public function cadastroTratativas(Request $request)
    {

        $data_renitencia = self::formataData($request['dataInicio']);
        $dados['id_cliente'] = $request['id_cliente'];
        $dados['id_titulo'] = $request['id_titulo'];
        $dados['id_ocorrencia'] = $request['id_ocorrencia'];
        $dados['descricao_tratativa'] = $request['descricao_tratativa'];
        $dados['Data_Renitencia'] = $data_renitencia;
        $dados['Valor'] = $request['Valor'];
        $dados['id_usuario'] = Auth::user()->id;
        $dados['nome_cliente'] = $request['nome_cliente'];
        $dados['saldo_devedor'] = $request['saldo_devedor'];
        $dados['vencimento_original'] =  implode("-", array_reverse(explode("/", $request['vencimento_original'])));
        $dados['vencimento_prorrogado'] =  implode("-", array_reverse(explode("/", $request['vencimento_prorrogado'])));
        $dados['created_at'] = Carbon::now();
        $dados['updated_at'] = Carbon::now();
        Tratativas::inserTratativas($dados);
    }


    /* * Cadastras as Tratativas Quando É Selecionado Mais de Um Título
     *
     */
    public function cadastroSelecaoTratativas(Request $request)
    {
        $titulos=null;
        for ($i = 0; $i < count($request->id_titulo); $i++) {
            $titulos=$titulos.$request->id_titulo[$i].',';
        }
        $tratativa['titulos']=substr($titulos, 0, -1);
        $tratativa['id_usuario'] = auth()->user()->id;
        $tratativa['id_cliente'] = $request->id_cliente;
        $tratativa['nome_cliente'] = $request->nome_cliente;
        $tratativa['saldo_devedor'] = $request->saldo_devedor;
        $tratativa['id_ocorrencia'] = $request->id_ocorrencia;
        $tratativa['descricao_tratativa'] = $request->descricao_tratativa;
        $tratativa['Valor'] = $request->Valor;
        $tratativa['Data_Renitencia'] = new Carbon($request->dataInicio);
        $tratativa['created_at'] = Carbon::now();
        $tratativa['updated_at'] = Carbon::now();
        Tratativas::inserTratativas($tratativa);
    }


    public function formataData($data)
    {
        $time = strtotime($data);
        $newformat = date('Y-m-d', $time);
        return $newformat;
    }
    /**
     * Pega Todos os Contatos Cadastrados de Um cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function getContatos($id)
    {
        return Contatos::getContatos($id);
    }

    /**
     * Pega Todos os Contatos de Email de Um Cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function getContatosEnvioEmail($id)
    {
        return Contatos::getContatosEnvioEmail($id);
    }

    /**

     * Encaminha para view de tratativas e manda os id´s dos titulos
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTratativas($id)
    {
        $dados = $id;
        return view('tratativas', compact('dados'));
    }

    /**
     * Retorna os titulos que seram tratados
     *
     * @return \Illuminate\Http\Response
     */
    public function getTitulos($id)
    {
        $dados = Clientes::getTitutlosId($id);
        return $dados;
    }

    /**
     * Retorna lista das descriçoes de ocorrencias 
     *
     * @return \Illuminate\Http\Response
     */

    public function getTipoOcorrencia()
    {
        $ocorrencias = Tratativas::getTipoOcorrencia();
        return $ocorrencias;
    }

    public function getIdOcorrencia($nome_ocorrencia)
    {
        return Tratativas::getIdOcorrencia($nome_ocorrencia);
    }

    /** Envia o Email com a Nota e o Título do Cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function enviaNotaTitulo(Request $request)
    {

        $i = 0;
        foreach ($request->emails as $dados) {
            if ($dados['email'] != null) {
                $emails[$i] = $dados['email'];
            }
            $i++;
        }
        $nota = 'Nota-' . $request->cdrcd . '.pdf';
        $dados =  Helper::gerarBoleto(TodosBoletos::getInformacaoBoleto($request->cdrcd), true);
        if ($dados['titulo']->TipoDeDocumento == 'Nota Fiscal de Serviço Eletrônica') {
            GerarNotaController::downloadNota($request->cdrcd);
        }
        Mail::to($emails)->send(new SendMailTituloNota($dados['anexo'], $dados['titulo'], $nota));
        event(new EnviarTitulo($dados['titulo']));
    }

    /**
     * 
     * Envia o Email de Lembrete de Pagamento com o Título do Cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function enviaLembrete(Request $request)
    {
        $i = 0;
        foreach ($request->emails as $dados) {
            if ($dados['email'] != null) {
                $emails[$i] = $dados['email'];
            }
            $i++;
        }
        $dados =  Helper::gerarBoleto(TodosBoletos::getInformacaoBoleto($request->cdrcd), true);
        Mail::to($emails)->send(new SendMailLembrete($dados['anexo'], $dados['titulo']));
        event(new EnviarLembrete($dados['titulo']));
    }

    public function getHistoricoTratativas($id_cliente)
    {
        $historico =  Tratativas::getHistoricoTratativas($id_cliente);
        return $historico;
    }

    /**
     * Pega o Cliente Informado no Campo de Busca do Receptivo
     *
     * @return \Illuminate\Http\Response
     */
    public function getReceptivo(Request $request)
    {
        try {
            $dados = Clientes::getCliente($request->CNPJ); //pega o ID do cliente
            if (Filas::verificaClienteFila($dados['id_cliente']) === 0) { //verifica se o cliente está na fila de atendimento
                $dados['id_usuario'] = auth()->user()->id;
                $dados['status'] = 1;
                Filas::removeClienteFilaAtendente($dados['id_usuario']); //retira da fila do atendente o cliente que atualmente esta em atendimento
                Filas::adicionaUmClientenaFila($dados); //adiciona o novo cliente na fila de atendimento
                return json_encode(['mensagem' => 'sucesso']);
            } else {
                if (Filas::verificaClienteFilaAtendente($dados['id_cliente']) === 0) { //verifica se o cliente já esta em atendimento
                    $dados['id_usuario'] = auth()->user()->id;
                    $dados['status'] = 1;
                    Filas::removeClienteFilaAtendente($dados['id_usuario']); //retira da fila do atendente o cliente que atualmente esta em atendimento
                    Filas::atualizaUmClienteNaFilaReceptivo($dados['id_cliente'], $dados['id_usuario']); //adiciona o cliente na fila de atendimento
                    return json_encode(['mensagem' => 'sucesso']);
                } else { //caso o cliente esteja em atendimento por outro operador não será possivel interagir com o mesmo
                    return json_encode(['mensagem' => 'em_atendimento']);
                }
            }
        } catch (\Throwable $th) {
            return json_encode(['mensagem' => 'nao_encontrado']);
        }
    }

    public function verificaSeExisteTratativaById($id_titulo)
    {

        return Tratativas::verificaSeExisteTratativaById($id_titulo);
    }
}
