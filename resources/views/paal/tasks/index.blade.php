@extends('paal.root')

@push('pageTitle', 'Tareas | Lista')

@push('headerTitle')
    <div class="row">
        <div class="col-md-2">
            @if (auth()->user()->level < 4)
                <a href="{{ route('paal.task.create') }}" class="btn btn-github btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
            @endif
        </div>
        <div class="col-md-7" style="text-align: center;">
            @include('paal.tasks._indicators')
        </div>
        <div class="col-md-3">
            <div class="pull-right">
                {!! Form::open(['method' => 'post', 'route' => 'paal.task.index']) !!}
                    <div class="input-group input-group-sm">
                        <input type="month" name="date" class="form-control" value="{{ $date }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-github btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <solid-box title="Mis tareas" color="primary">
                <data-table>

                    {{ drawHeader('iD', '<i class="fa fa-cogs"></i>', 'descripción', 'asignada a', 'asignó', 'límite', 'terminó', 'estado', 'observaciones') }}
                    
                    <template slot="body">
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>
                                    <dropdown color="primary" icon="cogs">
                                        @if (!$task->assigned_to)
                                            <ddi icon="edit" text="Editar/Asignar" to="{{ route('coffee.task.edit', $task) }}"></ddi>
                                        @endif
                                        @if ($task->status == 'terminada')
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
                                <td>{{ $task->user->name ?? 'sin asignar' }}</td>
                                <td>{{ $task->tasker->name }}</td>
                                <td style="{{ !$task->completed_at ? 'color: black;': ($task->onTime ? 'color: green;': 'color:red;') }}">
                                    {{ $task->assigned_at ? date('d/m/y', strtotime($task->assigned_at)): '' }}
                                </td>
                                <td style="{{ $task->onTime ? 'color: green;': 'color:red;' }}">
                                    {{ $task->completed_at ? date('d/m/y', strtotime($task->completed_at)): '' }}
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
                </data-table>
            </solid-box>
        </div>
    </div>

@endsection