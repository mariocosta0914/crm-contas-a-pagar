<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('home'));
    } else {
        return view('inicio');
    }
})->name('inicio');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('operador')->group(function () {
    Route::get('tratativas/{id}', 'ClientesController@indexTratativas')->name('tratativas');
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::prefix('admin')->middleware('supervisor')->group(function () {
    Route::get('usuarios', 'UsuariosController@index')->name('usuarios');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('cadastro-usuario');
    Route::get('form-excluir-usuario/{id}', 'UsuariosController@showExcluirUsuario');
    Route::put('excluir-usuario/{id}', 'UsuariosController@excluirUsuario');
    Route::get('form-editar-usuario/{id}', 'UsuariosController@showEditarUsuario');
    Route::get('editar-usuario/{id}', 'UsuariosController@editarUsuario')->name('editar-usuario');
    Route::get('home-supervisor', 'SupervisorController@index')->name('home-supervisor');
    Route::get('configuracao', 'SupervisorController@configuracao')->name('configuracao');
    Route::get('relatorios', 'SupervisorController@relatorios')->name('relatorios');
    Route::get('envio-diario', 'EnvioDiario@index')->name('envio-diario');
    Route::get('get-todos-clientes', 'EnvioDiario@getClientes');
    Route::get('get-clientes-bloqueados', 'EnvioDiario@getClientesBloqueados');
    Route::post('bloquear-cliente', 'EnvioDiario@bloquearCliente');
    Route::put('desbloquear-cliente/{id}', 'EnvioDiario@desbloquearCliente');
    

});


Route::prefix('api')->group(function () {
    Route::get('get-usuarios', 'UsuariosController@getUsuarios');
    Route::get('get-usuarios-relatorios', 'UsuariosController@getUsuariosRelatorios');
    Route::get('get-tipos-usuarios', 'UsuariosController@getUserType');
    Route::get('get-acesso-usuario/{id}', 'UsuariosController@getAcessoUsuario');
    Route::get('get-titulos/{id}', 'ClientesController@getTitulos')->name('tratativas');
    Route::get('get-titulos-valor/{id}', 'ClientesController@getQtdTitulosValor');
    Route::get('get-informacao-cliente/{id}', 'ClientesController@getDadosCliente');
    Route::get('get-informacao-titulos/{id}', 'ClientesController@getInforTitutlos');
    Route::post('adicionar-contatos', 'ClientesController@adicionaContatos');
    Route::get('get-contatos/{id}', 'ClientesController@getContatos');
    Route::get('get-contatos-envio-email/{id}', 'ClientesController@getContatosEnvioEmail');
    Route::get('get-boleto/{id}', 'BoletosController@index');
    Route::post('envia-nota-titulo', 'ClientesController@enviaNotaTitulo');
    Route::post('envia-lembrete', 'ClientesController@enviaLembrete');
    Route::get('get-ocorrencia', 'ClientesController@getTipoOcorrencia');
    Route::get('get-historico-tratativas/{id}','ClientesController@getHistoricoTratativas');
    Route::get('downloa-nota/{id}', 'GerarNotaController@downloadNota');
    Route::post('configuracao-fila', 'SupervisorController@filas');
    Route::post('salvar-fila', 'SupervisorController@createFila');
    Route::get('get-prioridades/{id}', 'SupervisorController@getPrioridades');
    Route::post('encerra-atendimento', 'HomeController@encerraAtendimento');
    Route::post('encerra-atendimento-sem-tratativa', 'HomeController@encerraAtendimentoSemTratativa');
    Route::get('get-id-ocorrencia/{nome_ocorrencia}', 'ClientesController@getIdOcorrencia');
    Route::post('cadastro-tratativa', 'ClientesController@cadastroTratativas');
    Route::post('cadastro-selecao-tratativa', 'ClientesController@cadastroSelecaoTratativas');
    Route::get('get-informacao-cliente/{id}', 'ClientesController@getDadosCliente');
    Route::post('get-receptivo', 'ClientesController@getReceptivo');
    Route::post('criar-relatorio', 'RelatorioController@index'); 
    Route::post('get-valores-fila', 'SupervisorController@getValoresFila'); 
    Route::post('get-intervalos', 'SupervisorController@getIntervalos'); 
    
});
