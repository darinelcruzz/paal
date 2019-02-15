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
                
                <data-table example="1">

                    {{ drawHeader('ID', 'nombre', 'usuario', 'compañía') }}

                    <template slot="body">
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    {{ $user->name }} &nbsp;&nbsp;
                                    <a href="{{ route('paal.user.edit', ['user' => $user->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->company == 'owner' ? 'Administrador': ucfirst($user->company) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection