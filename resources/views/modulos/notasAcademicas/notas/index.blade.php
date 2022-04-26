@extends('layouts.moduloPagosYmatricula')
@section('styles')

@endsection
@section('content')
<div id="notas" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- card notas --}}
            <div class="card">
                {{--  info --}}
                <div class="card-header">
                    <div v-if="matricula.vacante" class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Año: </b> @{{matricula.vacante.anio.nombre}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Cod. Matricula: </b> @{{matricula.id}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Nivel: </b> @{{matricula.vacante.nivel.nivel}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Seccion: </b> @{{matricula.vacante.grado.grado+'° '+matricula.vacante.seccion.seccion}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Alumno: </b> @{{alumno.apellidos+', '+alumno.nombres}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p :class="matricula.estado=='RETIRADO'?'text-danger':'text-primary'"><b>Estado Matricula: </b> @{{matricula.estado}} <span v-if="matricula.estado=='RETIRADO'">(@{{matricula.fecha_fin}})</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="nav-trimestre-tab" data-toggle="tab" href="#nav-trimestre" role="tab" aria-controls="nav-trimestre" aria-selected="true" v-on:click="obtenerNotas(1)">Trimestre I</a>
                                    <a class="nav-link" id="nav-trimestre-tab" data-toggle="tab" href="#nav-trimestre" role="tab" aria-controls="nav-trimestre" aria-selected="false" v-on:click="obtenerNotas(2)">Trimestre II</a>
                                    <a class="nav-link" id="nav-trimestre-tab" data-toggle="tab" href="#nav-trimestre" role="tab" aria-controls="nav-trimestre" aria-selected="false" v-on:click="obtenerNotas(3)">Trimestre II</a>
                                    <a class="nav-link" id="nav-pa-tab" data-toggle="tab" href="#nav-pa" role="tab" aria-controls="nav-pa" aria-selected="false" v-on:click="obtenerPromedioAnual()">Promedio Anual</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                {{-- seccion T1 --}}
                                <div class="tab-pane fade show active" id="nav-trimestre" role="tabpanel" aria-labelledby="nav-trimestre-tab">
                                    <h3>T @{{trimestre}}</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" colspan="1"></th>
                                                        <th scope="col" class="text-center"colspan="5">Competencia 1</th>
                                                        <th scope="col" class="text-center"colspan="5">Competencia 2</th>
                                                        <th scope="col" class="text-center"colspan="5">Competencia 3</th>
                                                        <th scope="col" class="text-center"colspan="5">Competencia 4</th>
                                                        <th class="text-center" scope="col" rowspan="2">Ex. Trim.</th>
                                                        <th class="text-center" scope="col" rowspan="2">P.<br>CT.</th>
                                                        <th class="text-center" scope="col" rowspan="2">P.<br>CL.</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Curso</th>
                                                        <th scope="col" >N 1</th>
                                                        <th scope="col" >N 2</th>
                                                        <th scope="col" >N 3</th>
                                                        <th scope="col" >N 4</th>
                                                        <th scope="col" >P. C.</th>
                                                        <th scope="col" >N 1</th>
                                                        <th scope="col" >N 2</th>
                                                        <th scope="col" >N 3</th>
                                                        <th scope="col" >N 4</th>
                                                        <th scope="col" >P. C.</th>
                                                        <th scope="col" >N 1</th>
                                                        <th scope="col" >N 2</th>
                                                        <th scope="col" >N 3</th>
                                                        <th scope="col" >N 4</th>
                                                        <th scope="col" >P. C.</th>
                                                        <th scope="col" >N 1</th>
                                                        <th scope="col" >N 2</th>
                                                        <th scope="col" >N 3</th>
                                                        <th scope="col" >N 4</th>
                                                        <th scope="col" >P. C.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-for="nota in notas">
                                                        <tr>
                                                            <td style="margin:2px !important; padding: 2px !important;">
                                                                @{{nota.responsable_vacante.responsable.curso.curso}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u1n1 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u1n1}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u1n2 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u1n2}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u1n3 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u1n3}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u1n4 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u1n4}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.pu1 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                <strong>@{{nota.pu1}}</strong>
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u2n1 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u2n1}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u2n2 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u2n2}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u2n3 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u2n3}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u2n4 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u2n4}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.pu2 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                <strong>@{{nota.pu2}}</strong>
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u3n1 <11 ? 'text-center text-danger':'text-center text-success'">
                                                                @{{nota.u3n1}}
                                                            </td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u3n2 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u3n2}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u3n3 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u3n3}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u3n4 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u3n4}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.pu3 <11 ? 'text-center text-danger':'text-center text-success'"><strong>@{{nota.pu3}}</strong></td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u4n1 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u4n1}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u4n2 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u4n2}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u4n3 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u4n3}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.u4n4 <11 ? 'text-center text-danger':'text-center text-success'">@{{nota.u4n4}}</td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.pu4 <11 ? 'text-center text-danger':'text-center text-success'"><strong>@{{nota.pu4}}</strong></td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.et <11 ? 'text-center text-danger':'text-center text-success'"><strong>@{{nota.et}}</strong></td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.ptn <11 ? 'text-center text-danger':'text-center text-success'"><strong>@{{nota.ptn}}</strong></td>
                                                            <td style="margin:2px !important; padding: 2px !important;" :class="nota.ptn <11 ? 'text-center text-danger':'text-center text-success'"><strong>@{{nota.ptc}}</strong></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- seccion promedio anual --}}
                                <div class="tab-pane fade" id="nav-pa" role="tabpanel" aria-labelledby="nav-pa-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Promedio Anual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="" id="matricula_id" value="{{$matricula_id}}" hidden>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/modulos/notasAcademicas/notas/index.js')}}"></script>
@endsection
