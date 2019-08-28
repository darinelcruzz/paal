@extends('mbe.root')

@push('pageTitle')
    Tareas | Lista
@endpush

@push('headerTitle')
    @if (auth()->user()->level < 4)
        <a href="{{ route('mbe.task.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Tareas/Actividades" color="success" button>
                
                <data-table example="1">

                    @if (true)

                        {{ drawHeader('iD', '<i class="fa fa-cogs"></i>', 'descripción', 'asignó', 'para', 'límite', 'terminó', 'estado', 'observaciones') }}

                        <template slot="body">
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        <dropdown color="success" icon="cogs">
                                            @if ($task->status != 'aceptada' && $task->assigned_to == auth()->user()->id)
                                                <li>
                                                    <a type="button" data-toggle="modal" data-target="#completeTask{{ $task->id }}">
                                                        <i class="fa fa-check"></i> Terminar
                                                    </a>
                                                </li>
                                            @endif

                                            @if ($task->status == 'terminada' && $task->assigned_by == auth()->user()->id)
                                                <li>
                                                    <a type="button" data-toggle="modal" data-target="#rejectTask{{ $task->id }}">
                                                        <i class="fa fa-times"></i> Rechazar
                                                    </a>
                                                </li>
                                                <ddi icon="check" text="Aceptar" to="{{ route('mbe.task.change', [$task, 'aceptada']) }}"></ddi>
                                            @endif
                                        </dropdown>

                                        <modal title="Razones" id="rejectTask{{ $task->id }}" color="#dd4b39">
                                            @include('mbe.tasks._add_reasons')
                                        </modal>

                                        <modal title="Tarea terminada" id="completeTask{{ $task->id }}" color="#dd4b39">
                                            @include('mbe.tasks._add_observations')
                                        </modal>
                                    </td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->tasker->name }}</td>
                                    <td>{{ $task->user->name }}</td>
                                    <td style="{{ !$task->completed_at ? 'color: black;': ($task->onTime ? 'color: green;': 'color:red;') }}">
                                        {{ fdate($task->assigned_at, 'd \d\e F', 'Y-m-d') }}
                                    </td>
                                    <td style="{{ $task->onTime ? 'color: green;': 'color:red;' }}">
                                        {{ fdate($task->completed_at, 'd \d\e F', 'Y-m-d') }}
                                    </td>
                                    <td>
                                        <label class="label label-{{ $task->status_color }}">
                                            {{ strtoupper($task->status) }} {{ $task->repetitions ? " ($task->repetitions)": '' }}
                                        </label>
                                    </td>
                                    <td>{!! $task->observations !!}</td>
                                </tr>
                            @endforeach
                        </template>

                    @else

                        {{ drawHeader('iD','<i class="fa fa-cogs"></i>', 'descripción', 'límite', 'terminó', 'estado', 'observaciones') }}

                        <template slot="body">
                            @foreach($tasks  as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        <dropdown color="success" icon="cogs">
                                            @if ($task->status != 'aceptada')
                                                <li>
                                                    <a type="button" data-toggle="modal" data-target="#completeTask{{ $task->id }}">
                                                        <i class="fa fa-check"></i> Terminar
                                                    </a>
                                                </li>
                                            @endif
                                        </dropdown>

                                        <modal title="Tarea terminada" id="completeTask{{ $task->id }}" color="#dd4b39">
                                            @include('mbe.tasks._add_observations')
                                        </modal>
                                    </td>
                                    <td>{{ $task->description }}</td>
                                    <td style="{{ !$task->completed_at ? 'color: black;': ($task->onTime ? 'color: green;': 'color:red;') }}">
                                        {{ fdate($task->assigned_at, 'd \d\e F', 'Y-m-d') }}
                                    </td>
                                    <td style="{{ $task->onTime ? 'color: green;': 'color:red;' }}">
                                        {{ fdate($task->completed_at, 'd \d\e F', 'Y-m-d') }}
                                    </td>
                                    <td>
                                        <label class="label label-{{ $task->status_color }}">
                                            {{ strtoupper($task->status) }} {{ $task->repetitions ? " ($task->repetitions)": '' }}
                                        </label>
                                    </td>
                                    <td>{!! $task->observations !!}</td>
                                </tr>
                            @endforeach
                        </template>
                    @endif
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection