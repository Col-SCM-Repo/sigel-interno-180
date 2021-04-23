<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    <li id="alumnos-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            ALUMNOS
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alumnos">
            <a class="dropdown-item" href="{{route('editar.alumno.alumnos', ['alumno_id' => 0])}}">
                Nuevo Alumno
            </a>
            <a class="dropdown-item" href="{{ route('index.alumnos') }}">
                Pagos
            </a>
        </div>
    </li>
    <li id="matriculas-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            MATRICULAS
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
            <a class="dropdown-item" href="{{ route('index.aula') }}">
                Aulas
            </a>
            <a class="dropdown-item" href="{{ route('nueva.matriculas', ['alumno_id'=>0,'matricula_id'=>0]) }}">
                Nueva Matrícula
            </a>
        </div>
    </li>
    <li id="reportes-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            REPORTES
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
            <a class="dropdown-item" href="{{ route('vista.pagos.del.dia.pagos') }}">
                Pagos Por Usuario
            </a>
            <a class="dropdown-item" href="{{ route('vista.por.nivel.anio_actual.vacantes') }}">
                Alumnos Por Año y Nivel
            </a>
            <a class="dropdown-item" href="{{ route('vista.morosos.alumnos') }}">
                Alumnos Morosos
            </a>
            <a class="dropdown-item" href="{{ route('vista.pagos.entre.fechas.pagos') }}">
                Pagos Entre Fechas
            </a>
        </div>
    </li>
</ul>
<!-- Right Side Of Navbar -->
