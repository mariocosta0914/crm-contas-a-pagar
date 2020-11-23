@extends('layouts.app')

@section('content')
<div>
    <h3><strong> Página Inicial</strong></h3>
    <hr>
</div>
<div class="row">
    <div class="col-md-12">
        <card-generico>
            <div class="row">
                <div class="col-md-3">
                    <a href="{{route('usuarios')}}">
                        <card-generico class="text-center">
                            <i class="fa fa-users fa-5x" aria-hidden="true"></i>
                            <div class="card-body">
                                <h4 class="card-text font-weight-bolder">Usuários</h4>
                            </div>
                        </card-generico>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{route('relatorios')}}">
                        <card-generico class="text-center">
                            <i class="fa fa-file-text fa-5x" aria-hidden="true"></i>
                            <div class="card-body">
                                <h4 class="card-text font-weight-bolder">Relatórios</h4>
                            </div>
                        </card-generico>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{route('envio-diario')}}">
                        <card-generico class="text-center">
                            <i class="fa fa-paper-plane  fa-5x" aria-hidden="true"></i>
                            <div class="card-body">
                                <h4 class="card-text font-weight-bolder">Envio diario</h4>
                            </div>
                        </card-generico>
                    </a>
                </div>

                

                <div class="col-md-3">
                    <a href="{{route('configuracao')}}">
                        <card-generico class="text-center">
                            <i class="fa fa-cog fa-5x" aria-hidden="true"></i>
                            <div class="card-body">
                                <h4 class="card-text font-weight-bolder">Configuração</h4>
                            </div>
                        </card-generico>
                    </a>
                </div>
                
            </div>
        </card-generico>
    </div>
</div>
@endsection