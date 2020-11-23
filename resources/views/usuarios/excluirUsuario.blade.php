@extends('layouts.app')

@section('content')
<h3><strong>Excluir Usuário: {{$dados->name}}</strong></h3>
<hr />
<div class="d-flex justify-content-center">
    <div class="col-md-6">
        <card-generico>
            <excluir-usuario v-bind:dados="{{$dados}}" token="{{csrf_token()}}" url="{{url('admin/excluir-usuario')}}"
            url_voltar="{{route('usuarios')}}"/>
        </card-generico>
    </div>
</div>
@endsection