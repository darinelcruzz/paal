@extends('coffee.root')

@push('pageTitle', 'Análisis | Lugares')

@push('headerTitle')
    {!! Form::open(['method' => 'post', 'route' => 'coffee.statistics.places']) !!}
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="month" name="date" class="form-control" value="{{ $date }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endpush

@section('content')

    <div class="row">
        <div class="col-md-5">
            <solid-box title="ENVÍOS" color="danger">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><small>ESTADO</small></th>
                            <th style="text-align: center; width: 5%;"><small><i class="fa fa-eye"></i></small></th>
                            <th style="text-align: center; width: 15%;"><small>ENVÍOS</small></th>
                            <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ingressesByState as $state => $collection)
                        {{-- @dd($collection) --}}
                        <tr>
                            <td>{{ $state == '' ? 'NO AÑADIDO': $state }}</td>
                            <td>
                                @if($state != '')
                                <a data-toggle="modal" data-target="#cities{{ $loop->index }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <modal title="{{ $state }}" color="danger" id="cities{{ $loop->index }}">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;"><small>CIUDAD</small></th>
                                                    <th style="text-align: center;width: 10%;"><small>ENVÍOS</small></th>
                                                    <th style="text-align: right;width: 20%;"><small>MONTO</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($collection->groupBy(function ($ingress) {return strtoupper($ingress->client->shipping_address->city);}) as $city => $values)
                                                {{-- @dd($values) --}}
                                                <tr>
                                                    <td style="width: 70%;">
                                                        <small>{{ $city }}</small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $values->count() }}
                                                    </td>
                                                    <td style="text-align: right;">{{ number_format($values->sum(function ($ingress)
                                                    {
                                                        return $ingress->amount;
                                                    }), 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </modal>
                                @else
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $collection->count() }}</td>
                            <td style="text-align: right;">{{ number_format($collection->sum(function ($ingress) { return $ingress->amount; }), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="2"></th>
                            <th style="text-align: center;">{{ $ingressesByState->sum(function ($state) { return $state->count(); }) }}</th>
                            <th style="text-align: right;">{{ number_format($ingressesByState->sum(function ($state) { return $state->sum('amount'); }), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="TOP 5 LUGARES" color="danger">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;"><small>#</small></th>
                            <th><small>CIUDAD</small></th>
                            <th style="text-align: center; width: 15%;"><small>ENVÍOS</small></th>
                            <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($topPlaces as $city => $collection)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>{{ $city == '' ? 'NO AÑADIDO': $city }}</td>
                            <td style="text-align: center;">{{ $collection->count() }}</td>
                            <td style="text-align: right;">{{ number_format($collection->sum(function ($ingress) { return $ingress->amount; }), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="text-align: center;">{{ $topPlaces->sum(function ($place) { return $place->count(); }) }}</th>
                            <th style="text-align: right;">{{ number_format($topPlaces->sum(function ($place) { return $place->sum('amount'); }), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>
    </div>

@endsection
