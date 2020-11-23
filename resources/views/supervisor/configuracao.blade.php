@extends('layouts.app')

@section('content')
<div>
    <h3><strong> Configuração</strong></h3>
    <hr>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">ISP</h5>
                <hr />
                <div>
                    <configuracao segmento="ISP"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">Corporativo</h5>
                <hr />
                <div>
                    <configuracao segmento="CORPORATIVO"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">Governo</h5>
                <hr />
                <div>
                    <configuracao segmento="GOVERNO"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">Operadora</h5>
                <hr />
                <div>
                    <configuracao segmento="Operadora"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">Percentil</h5>
                <hr />
                <div>
                    <configuracao segmento="Percentil"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <card-generico>
                <h5 class="card-title">Sem Segmentação</h5>
                <hr />
                <div>
                    <configuracao segmento="Sem Segmentação"></configuracao>
                </div>
            </card-generico>
        </div>
    </div>
</div>
@endsection