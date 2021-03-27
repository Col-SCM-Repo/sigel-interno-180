@extends('layouts.app')

@section('content')
<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">REGISTRAR PAGOS</div>

                <div class="card-body">
                  <p>Total de usuarios modificados: {{$cant}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/pagos/index.js')}}"></script>
@endsection
