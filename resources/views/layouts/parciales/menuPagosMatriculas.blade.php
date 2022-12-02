<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    <li id="alumnos-nav" class="nav-item dropdown ">
        <a  class="nav-link " href="{{ route('index.alumnos') }}" role="button" >
            ALUMNOS
        </a>
    </li>
    <li id="matriculas-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            AULAS
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
            <a class="dropdown-item" href="{{ route('por.anio.vacantes') }}">
                Por Año
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
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportes">
            <a class="dropdown-item" href="{{ route('pagos.por.fecha.usuario.actual.pagos') }}">
                Pagos Por Usuario
            </a>
            <a class="dropdown-item" href="{{ route('vista.total.alumno.anio.nivel.vacantes') }}">
                Alumnos Por Año y Nivel
            </a>
            <a class="dropdown-item" href="{{ route('vista.morosos.alumnos') }}">
                Alumnos Morosos
            </a>
            <a class="dropdown-item" href="{{ route('vista.pagos.entre.fechas.pagos') }}">
                Pagos Entre Fechas
            </a>
            <a class="dropdown-item" href="{{ route('vista.pagos.entre.fechas.pagos-xml') }}">
                Envio de comprobantes XML
            </a>
        </div>
    </li>
    <li id="mantenimiento-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            MANTENIMIENTO
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="mantenimiento">
            <a class="dropdown-item" href="{{ route('documentos.index', ['modulo'=>'pagos y matriculas']) }}">
                Documentos
            </a>
        </div>
    </li>
    {{-- <li id="mantenimiento-nav" class="nav-item dropdown ">
        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            MANTENIMIENTO
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="matriculas">
            <a class="dropdown-item" href="{{ route('index.vista.anios') }}">
                Año Escolar
            </a>
            <a class="dropdown-item" href="{{ route('index.usuario') }}">
                Usuarios
            </a>
        </div>
    </li> --}}
</ul>
