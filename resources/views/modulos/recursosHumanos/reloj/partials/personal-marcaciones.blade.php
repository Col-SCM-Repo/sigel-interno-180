
<table class="col-12 col-md-9 mx-auto mt-5 text-uppercase text-center" border="1" style="border-collapse: collapse; #333">
    <thead style="background: #3CE">
        <tr>
            <th colspan="5" class="text-center">
                REPORTE DE MARCACIONES
            </th>
        </tr>
        <tr>
            <th class="text-uppercase text-center" >Dia</th>
            <th class="text-uppercase text-center" >Turno</th>
            <th class="text-uppercase text-center" >Fecha</th>
            <th class="text-uppercase text-center" >Hora</th>
            <th class="text-uppercase text-center" >Local</th>
        </tr>
    </thead>
    <tbody>
        
        @if (count($data->marcaciones)>0)
            @foreach ($data->marcaciones as $marcacion)
                <tr>
                    <td> {{ $marcacion->nDia }} </td>
                    <td> {{ $marcacion->nTurno }} </td>
                    <td> {{ $marcacion->nFecha }} </td>
                    <td> {{ $marcacion->nHora }} </td>
                    <td> {{ $marcacion->nLocal }} </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" style="height: 100px" class="text-center"> No se encontro marcaciones</td>
            </tr>
        @endif
    </tbody>
</table>
