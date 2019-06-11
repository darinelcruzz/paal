@extends('coffee.root')

@push('pageTitle')
    Tareas | Lista
@endpush

@push('headerTitle')
    @if (auth()->user()->company == 'owner')
        <a href="{{ route('coffee.task.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Tareas/Actividades" color="danger" button>
                
                <data-table example="1">

                    @if (auth()->user()->company == 'owner')

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
                                        <label class="label label-{{ $task->status == 'pendiente' ? 'warning': 'success ' }}">{{ strtoupper($task->status) }}</label>
                                    </td>
                                    <td>{{ $task->observations }}</td>
                                </tr>
                            @endforeach
                        </template>

                    @else

                        {{ drawHeader('iD','<i class="fa fa-cogs"></i>', 'descripción', 'fecha límite', 'estado', 'observaciones') }}

                        <template slot="body">
                            @foreach(auth()->user()->myTasks as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        <dropdown color="danger" icon="cogs">
                                            @if ($task->status != 'terminada')
                                                <li>
                                                    <a type="button" data-toggle="modal" data-target="#completeTask{{ $task->id }}">
                                                        <i class="fa fa-check"></i> Terminar
                                                    </a>
                                                </li>
                                            @endif
                                        </dropdown>

                                        <modal title="Tarea terminada" id="completeTask{{ $task->id }}" color="#dd4b39">
                                            @include('coffee.tasks._add_observations')
                                        </modal>
                                    </td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->assigned_at }}</td>
                                    <td>
                                        <label class="label label-{{ $task->status == 'pendiente' ? 'warning': 'success ' }}">{{ strtoupper($task->status) }}</label>
                                    </td>
                                    <td>{{ $task->observations }}</td>
                                </tr>
                            @endforeach
                        </template>
                    @endif
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection