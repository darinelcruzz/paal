@extends('coffee.root')

@push('pageTitle')
    Tareas | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('coffee.task.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Tareas/Actividades" color="danger" button>
                
                <data-table example="1">

                    {{ drawHeader('iD', 'descripción', 'encargada por', 'encargada a', 'fecha límite', 'estado', 'observaciones') }}

                    <template slot="body">
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->tasker->name }}</td>
                                <td>{{ $task->user->name }}</td>
                                <td>{{ $task->assigned_at }}</td>
                                <td>
                                    <label class="label label-{{ $task->status == 'pendiente' ? 'warning': 'success' }}">{{ strtoupper($task->status) }}</label>
                                </td>
                                <td>{{ $task->observations }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection