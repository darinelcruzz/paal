@extends('coffee.root')

@push('pageTitle', 'Tareas | Lista')

@push('headerTitle')
    <div class="row">
        <div class="col-md-2">
            @if (auth()->user()->level < 4)
                <a href="{{ route('coffee.task.create') }}" class="btn btn-warning btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
            @endif
        </div>
        <div class="col-md-7" style="text-align: center;">
            @include('coffee.tasks._indicators')
        </div>
        <div class="col-md-3">
            <div class="pull-right">
                {!! Form::open(['method' => 'post', 'route' => 'coffee.task.index']) !!}
                    <div class="input-group input-group-sm">
                        <input type="month" name="date" class="form-control" value="{{ $date }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
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

            @if($mytasks->count() > 0)

                <solid-box title="Mis tareas" color="success">
                    <data-table>

                        {{ drawHeader('iD', '<i class="fa fa-cogs"></i>', 'descripción', 'asignó', 'límite', 'terminó', 'estado', 'observaciones') }}
                        
                        <template slot="body">
                            @foreach($mytasks as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        <dropdown color="success" icon="cogs">
                                            @if ($task->status != 'terminada' && $task->assigned_to == auth()->user()->id)
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
                    </data-table>
                </solid-box>
            @endif
        </div>
    </div>

    @forelse($users as $user => $tasks)
        <div class="row">
            <div class="col-md-12">
                <solid-box title="{{ $tasks->first()->user->name ?? 'SIN ASIGNAR' }}" color="{{ $loop->iteration % 2 == 0 ? 'danger': 'warning' }}" button {{ $loop->iteration == 1 ? '': ' collapsed'}}>

                    <div class="row">
                        <div class="col-md-12">
                            @include('coffee.tasks._indicators', ['buttonSize' => 'btn-xs'])
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <data-table example="1">

                                {{ drawHeader('iD', '<i class="fa fa-cogs"></i>', 'descripción', 'asignó', 'límite', 'terminó', 'estado', 'observaciones') }}

                                <template slot="body">
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>
                                                <dropdown color="{{ $loop->parent->iteration % 2 == 0 ? 'danger': 'warning' }}" icon="cogs">
                                                    @if (!$task->assigned_to)
                                                        <ddi icon="edit" text="Editar/Asignar" to="{{ route('coffee.task.edit', $task) }}"></ddi>
                                                    @endif

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
                                                                <i class="fa fa-eye"></i> Revisar
                                                            </a>
                                                        </li>
                                                        {{-- <ddi icon="check" text="Aceptar" to="{{ route('coffee.task.change', [$task, 'aceptada']) }}"></ddi> --}}
                                                    @endif
                                                </dropdown>

                                                <modal title="Razones" id="rejectTask{{ $task->id }}" color="#dd4b39">
                                                    @include('coffee.tasks._add_reasons')
                                                </modal>

                                                <modal title="Tarea terminada" id="completeTask{{ $task->id }}" color="#dd4b39">
                                                    @include('coffee.tasks._add_observations')
                                                </modal>
                                            </td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->tasker->name }}</td>
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
                            </data-table>
                            
                        </div>
                    </div>
                    

                </solid-box>
            </div>
        </div>
    @empty
        <h2>
            <code>NO HAY TAREAS ASIGNADAS</code>
        </h2>
    @endforelse

@endsection