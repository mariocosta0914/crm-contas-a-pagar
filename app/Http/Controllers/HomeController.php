<?php

namespace App\Http\Controllers;

use App\Atendimento;
use App\Clientes;
use App\Filas;
use App\Tratativas;
use App\UserAccessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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
     * Cria toda a Logica de acesso as filas
     * Primeiro verifica se a sessão foi criada, caso não tenha sido criado
     * é feita a criação
     * Segundo pega o tipo de usuário (podendo ser 1 ou mais)
     * Terceiro verifica se o usuário logado possui alguma cliente na fila
     * caso exista é retornado o ID desse cliente se não existe cliente na fila
     * é adicionado um cliente. 
     */
    public function index()
    {
        $contador=0;
        if (!Session::has('tipo_usuario')) { //verifica se existe sessão criada
            $tipo_usuario = UserAccessType::getUserTypeByIdUser(auth()->user()->id); //pega os tipos de fila que o usuário tem
            $id_cliente = Filas::getIdCliente(auth()->user()->id); //pega o cliente que está na fila do atendente
            Session::put('tipo_usuario', $tipo_usuario); //caso não tenha sido criado uma sessão para as fila a mesma é criada
            $fila_sessao = Session::get('tipo_usuario');
            while ($id_cliente === NULL) { //caso a fila tenha ficado vazia é passado para uma fila que tenhas clientes
                $valor_fila_atual = $fila_sessao[array_key_first($fila_sessao)]; //pega a fila atual do atendente
                unset($fila_sessao[array_key_first($fila_sessao)]); //remove o primero elemento da fila atual
                array_push($fila_sessao, $valor_fila_atual); //adiciona o elemento removido para o final da fila
                Session::put('tipo_usuario', $fila_sessao); //atualiza a sessão com a nova ordem da fila
                $id_cliente = Filas::adicionaUsuarioFila(auth()->user()->id, $fila_sessao[array_key_first($fila_sessao)]); //adiciona um cliente a fila do atendente e retorna o id do cliente
                $contador++;
                if($contador>=10){ //condição onde verifica se todas as filas desse atendente estão vazias
                    return view('fila_vazia');
                }
            }
        } else {
            $fila_sessao = Session::get('tipo_usuario');
            $id_cliente = Filas::getIdCliente(auth()->user()->id); //pega o cliente que está na fila do atendente
            while ($id_cliente === NULL) { //caso a fila tenha ficado vazia é passado para uma fila que tenhas clientes
                $valor_fila_atual = $fila_sessao[array_key_first($fila_sessao)]; //pega a fila atual do atendente
                unset($fila_sessao[array_key_first($fila_sessao)]); //remove o primero elemento da fila atual
                array_push($fila_sessao, $valor_fila_atual); //adiciona o elemento removido para o final da fila
                Session::put('tipo_usuario', $fila_sessao); //atualiza a sessão com a nova ordem da fila
                $id_cliente = Filas::adicionaUsuarioFila(auth()->user()->id, $fila_sessao[array_key_first($fila_sessao)]); //adiciona um cliente a fila do atendente e retorna o id do cliente
                $contador++;
                if($contador>=10){ //condição onde verifica se todas as filas desse atendente estão vazias
                   return view('fila_vazia');
                }
            }
        }
        $dados['id_cliente'] = $id_cliente['id_cliente'];
        $dados['valor'] = Clientes::getQtdTitulos($id_cliente['id_cliente'])->valor_devido;
        return view('home', compact('dados'));
    }


    /**
     * Encerra o atendimento desse cliente, reordena o array da sessão 
     * caso tenha mais de um elemento(esse array possui o tipo de fila que o 
     * atendente pode atender)
     * e aloca o proximo para a fila do atendente
     */
    public function encerraAtendimento(Request $request)
    {
        $contador = Tratativas::verificaSeExisteTratativa($request->id_cliente); //verifica se existe tratativas feitas para a data de hoje
        if ($contador != 0) {
            Filas::removeClienteFila(auth()->user()->id); //remove o cliente da fila do atendente
            Atendimento::insertAtendimento(
                array(
                    'id_usuario' => auth()->user()->id,
                    'id_cliente' => $request->id_cliente
                )
            ); //salva o atendimento no banco de dados
            $fila_sequencia = Session::get('tipo_usuario'); // pega os tipos de fila que o atendente possui na sessão
            $valor_fila_atual = $fila_sequencia[array_key_first($fila_sequencia)]; //pega a fila atual do atendente
            unset($fila_sequencia[array_key_first($fila_sequencia)]); //remove o primero elemento da fila atual
            array_push($fila_sequencia, $valor_fila_atual); //adiciona o elemento removido para o final da fila
            Session::put('tipo_usuario', $fila_sequencia); //atualiza a sessão com a nova ordem da fila
            return json_encode(['mensagem' => 'sucesso']);
        } else {
            echo json_encode(['mensagem' => 'sem_tratativa']);
        }
    }

    /**
     * Encerra o atendimento desse cliente, reordena o array da sessão 
     * caso tenha mais de um elemento(esse array possui o tipo de fila que o 
     * atendente pode atender)
     * e aloca o proximo para a fila do atendente
     */
    public function encerraAtendimentoSemTratativa(Request $request)
    {
        Filas::removeClienteFila(auth()->user()->id); //remove o cliente da fila do atendente
        Atendimento::insertAtendimento(
            array(
                'id_usuario' => auth()->user()->id,
                'id_cliente' => $request->id_cliente,
                'observacao' => $request->observacao
            )
        ); //salva o atendimento no banco de dados
        $fila_sequencia = Session::get('tipo_usuario'); // pega os tipos de fila que o atendente possui na sessão
        $valor_fila_atual = $fila_sequencia[array_key_first($fila_sequencia)]; //pega a fila atual do atendente
        unset($fila_sequencia[array_key_first($fila_sequencia)]); //remove o primero elemento da fila atual
        array_push($fila_sequencia, $valor_fila_atual); //adiciona o elemento removido para o final da fila
        Session::put('tipo_usuario', $fila_sequencia); //atualiza a sessão com a nova ordem da fila
        return json_encode(['mensagem' => 'sucesso']);
    }
}
