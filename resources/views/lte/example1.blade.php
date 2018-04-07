@extends('control.admin.root')

@push('pageTitle')
    Alma Medics | Inicio
@endpush

@push('headerTitle')
    Inicio <small>COMIENZA AQUÍ</small>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box color="danger" title="Datos" button collapsed>
                <data-table example="1">
                    <template slot="header">
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Horario</th>
                            <th>Contacto</th>
                            <th>Correo</th>
                        </tr>
                    </template>

                    <template slot="body">
                        <tr>
                            <td>1</td>
                            <td>Doctor Simi</td>
                            <td>9:00 a.m. a 12:00 p.m.</td>
                            <td>961-122-7856</td>
                            <td>docsimi@similares.com</td>
                        </tr>
                    </template>
                </data-table>
            </solid-box>
        </div>
    </div>

@endsection
