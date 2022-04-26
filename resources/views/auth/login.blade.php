@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" minlength="8">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAutorizacion" tabindex="-1" role="dialog"  data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered " role="document" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">ADVERTENCIA</h5>
        </div>
        <div class="modal-body">
            El uso de este sistema sólo está permitido a los usuarios autorizados. <br> <br>
            El acceso no autorizado está terminantemente prohibido y podrá ser objeto de acciones disciplinarias, sin perjuicio de las restantes acciones de naturaleza legal a las que hubiere lugar. <br> <br>
            Toda la actividad de este sistema se registra y es revisada periódicamente por el personal designado por la Gerencia del COMPLEJO EDUCATIVO CABRERA EIRL. <br> <br>
            Cualquier usuario que acceda al sistema lo hace declarando conocer y aceptar íntegramente estas reglas y la Normativa General de Utilización de los Recursos y Sistemas de Información del COMPLEJO.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btnCondiciones"data-dismiss="modal" >Acepto</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    //Lanzar modal
    window.onload= function(){
        $("#modalAutorizacion").modal("show");
    }
</script>
@endsection
