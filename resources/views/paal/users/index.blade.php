@extends('paal.root')

@push('pageTitle')
    Usuarios | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.user.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Usuarios" color="primary" button>
                
                <table class="table table-striped table-bordered table-hover table-condensed spanish">
                    <thead>
                        <tr>
                            <th style="width: 5%;"><small>ID</small></th>
                            <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                            <th><small>NOMBRE</small></th>
                            <th><small>USUARIO</small></th>
                            <th><small>COMPAÑÍA</small></th>
                            <th><small>TIENDA</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <a href="{{ route('paal.user.edit', ['user' => $user->id]) }}" class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ ucfirst($user->company->name ?? '' ) }}</td>
                            <td>{{ ucfirst($user->store->name ?? '' ) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </solid-box>
        </div>
    </div>

@endsection