<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Validation\Rule;
use App\UserAccessType;

class UsuariosController extends Controller
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'tipos' => ['required'],
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($data['id'])],
            'password' => ['confirmed'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.listagemUsuarios');
    }

    /**
     * Formulário para Edição de um Usuário
     */
    public function showEditarUsuario($id)
    {
        $dados = User::getUserById($id);
        return view('usuarios.editarUsuario', compact('dados'));
    }

    /**
     * Método de Edição de um Usuário do Sistema
     */
    public function editarUsuario(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        $dados['name']=$request->name;
        $dados['email']=$request->email;
        $dados['password']=$request->password;
        User::updateUsuario($dados,$id);

        $dados['id_usuario']=$id;
        UserAccessType::excluirUsuarioAcesso($id);

        $tipo_usuario = explode(",", $request->tipos);
        for($i=0;$i<count($tipo_usuario);$i++){
            if($tipo_usuario[$i]==1){
                User::updateUsuario(array('supervisor'=>'1','password'=>null),$dados['id_usuario']);
            }
            else{
                User::updateUsuario(array('supervisor'=>'0','password'=>null),$dados['id_usuario']);
            }
            $dados['id_tipo_usuario']=$tipo_usuario[$i];
            UserAccessType::adicionarUsuarioTipoAcesso($dados);
        }

        Session::flash('mensagem', 'Edição de Usuário Feita com Sucesso!!!');
        return redirect(route('usuarios'));

    }

    /**
     * Formulário para Exlusão de um Usuário
     */
    public function showExcluirUsuario($id)
    {
        $dados = User::getUserById($id);
        return view('usuarios.excluirUsuario', compact('dados'));
    }


    /**
     * Método de Exclusão de um Usuário do Sistema
     */
    public function excluirUsuario(Request $request)
    {
        $dados['status'] = 0;
        User::excluirUsuario($dados, $request->id);
        Session::flash('mensagem', 'Usuário Excluido com Sucesso!!!');
        return redirect(route('usuarios'));
    }

    /**
     * Lista Todos os Usuários Cadastrados no Sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsuarios()
    {
        $dados['dados_usuario'] = User::getUsuarios();
        $dados['dados_acessso'] = User::getAcessos();
        return $dados;
    }


    /**
     * Pega Todos os Tipos de Usuários Cadastrados no Sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserType()
    {
        return User::getUserType();
    }

    /**
     * Pega o Tipo de Acesso de Um Único Usuário
     *
     * @return \Illuminate\Http\Response
     */
    public function getAcessoUsuario($id)
    {
        return User::getUserTypeById($id);
    }

    /**
     * Pega Todos os Operadores do Sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsuariosRelatorios()
    {
        return User::getUserOperador();
    }
}
