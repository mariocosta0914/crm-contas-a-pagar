@extends('layouts.app')

@section('content')
<h3><strong>Listagem de Usuários</strong></h3>
<hr />
@if(Session::has('mensagem'))
<mensagens mensagem="{{Session::get('mensagem')}}" tipo="sucesso"></mensagens>
@endif
<a type="button" class="btn btn-primary" href="{{route('cadastro-usuario')}}">Adicionar Usuário</a>
<tabela-usuarios url_editar_usuario="{{url('admin/form-editar-usuario')}}" url_excluir_usuario="{{url('admin/form-excluir-usuario')}}"></tabela-usuarios>
@endsection