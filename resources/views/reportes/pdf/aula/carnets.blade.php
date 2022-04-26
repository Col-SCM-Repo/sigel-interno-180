<!DOCTYPE html>
<html lang="es">
<head>
  <title>Generar Carnet</title>
  <style media="screen">
  *,*::after{
    padding: 0px;
    margin: 0px;
    border: 0px;
    font-family: sans-serif;
    font-size: 11px;
  }
  html,body{
    box-sizing: border-box;
    padding: 0px;
    margin: 0px;
    height: 204px;
  }
  .design{
    border: 0px;
    width: 326.5px;
    height: 208px;
    margin-left: -0.4px;
    margin-bottom: -13.3px;
  }
  table{
    width: 278px;
    height: 207px;
    position: absolute;
    border-collapse:collapse;
    border-spacing:0;
  }
  .tc{
    text-align: center;
    padding: 0px;
    margin: 0px;
  }
  .imgUser{
    padding: 0px;
    margin: 0px;
    padding-left: 29px;
    padding-bottom: 8px;
    width: 85px;
    height: 121px;
  }
  .breakLine{
    width: 326.5px;
    height: 0.1px;
  }

</style>
</head>
<body>
  @foreach ($matriculas as $matricula)
    @if ($matricula->estado != 4)
        <div class="cardsDesignTop">
            <p class="breakLine">.</p>
            <table>
                <tr>
                    <th colspan="2" style="height:45px;"></th>
                </tr>
                <tr>
                    <td rowspan="4" style="width:114px;">
                        <img class="imgUser" src="{{$matricula->alumno->url_foto}}" alt="user">
                    </td>
                    <td class="tc" style="padding-bottom:2px;font-size:1.3em">{{$matricula->id}}</td>
                </tr>
                <tr>
                    <td class="tc" style="height:32px; padding-bottom: 1.5px; font-size: 9.5px;">{{$matricula->alumno->apellidos}}</td>
                </tr>
                <tr>
                    <td class="tc" style="height:32px; padding-bottom: 2px; font-size: 9.5px;">{{$matricula->alumno->nombres}}</td>
                </tr>
                <tr>
                    <td class="tc" style="height:37px;font-size:1.3em">{{$matricula->vacante->grado->grado.'° '.$matricula->vacante->seccion->seccion}}</td>
                </tr>
            </table>
            <img class="design" src="{{$matricula->frente_carnet}}"/>
        </div>
        <div>
            <img class="design" src="{{$matricula->reverso_carnet}}"/>
        </div>
    @endif

@endforeach
</body>
</html>
