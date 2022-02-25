@extends('coffee.root')

@push('pageTitle', 'Ediciones | Historial')

@section('content')
    <div class="row">
        <div class="col-md-10">

            <solid-box title="Ediciones" color="danger">

                <div class="table-responsive">

                <table class="table table-striped table-bordered spanish-simple">
                    <thead>
                        <tr>
                            <th style="text-align: center;"><small>#</small></th>
                            <th><small>VENTA</small></th>
                            <th><small>EMPRESA</small></th>
                            <th><small>FECHA</small></th>
                            <th><small>HORA</small></th>
                            <th style="width: 50%;"><small>CAMBIOS</small></th>
                            <th><small>HECHO POR</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->loggable->ingress->folio }}</td>
                                <td><small>{{ strtoupper($log->loggable->ingress->company) }}</small></td>
                                <td>{{ date('d/m/y', strtotime($log->created_at)) }}</td>
                                <td>{{ date('H:ia', strtotime($log->created_at)) }}</td>
                                <td>
                                    @foreach(explode(',', $log->description) as $change)
                                    {{ $change }} @if(!$loop->last) <br> @endif
                                    @endforeach
                                </td>                                
                                <td>{{ $log->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                </div>

            </solid-box>
        </div>
    </div>
@endsection