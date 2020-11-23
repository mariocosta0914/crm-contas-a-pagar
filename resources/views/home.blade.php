@extends('layouts.app')

@section('content')
<div>
    <receptivo/>
</div>
<hr>
<div class="row">
    <div class="col-md-9">
        <card-generico sombra="true">
            <cliente-informacoes id="{{$dados['id_cliente']}}" />
        </card-generico>
    </div>
    <div class="col-md-3">
        <card-generico sombra="true" class="h-100">
            <cliente-informacoes-financeiras id="{{$dados['id_cliente']}}"/>
        </card-generico>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <card-generico sombra="true">
            <tabela-titulos url="{{url('tratativas')}}" 
            id_cliente="{{$dados['id_cliente']}}" 
            url_boleto="{{url('api/get-boleto')}}" 
            url_nota="{{url('api/downloa-nota')}}" 
            valor_devido="{{$dados['valor']}}"
            user_logado="{{auth()->check()}}"/>
            
        </card-generico>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <historico-tratativas id_cliente="{{$dados['id_cliente']}}" />
    </div>
</div>
@endsection