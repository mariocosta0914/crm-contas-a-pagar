@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <card-generico sombra="true">
            <fila-vazia url="{{route('home')}}"/>
        </card-generico>
    </div>
</div>
@endsection