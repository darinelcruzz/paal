@extends('coffee.root')

@push('pageTitle')
    Egresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => 'coffee.egress.index']) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-success btn-bg btn-block">
                            $ {{ number_format($egresses->where('status', 'pagado')->sum('amount') + $egresses->where('status', 'pagado')->sum('iva'), 2) }}
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-warning btn-bg btn-block">
                            $ {{ number_format($alltime->where('status', 'pendiente')->sum('amount') + $alltime->where('status', 'pendiente')->sum('iva'), 2) }}
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-danger btn-bg btn-block">
                            $ {{ number_format($alltime->where('status', 'vencido')->sum('amount') + $alltime->where('status', 'vencido')->sum('iva'), 2) }}
                        </label>
                    </div>
                </div>


            <br>

            <solid-box title="Egresos" color="danger" button>

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'folio', 'proveedor','compra', 'I.V.A.', 'total', 'pago', 'estado') }}

                    <template slot="body">
                        @foreach($egresses as $egress)
                            <tr>
                                <td>{{ $egress->id }}</td>
                                <td>
                                    @include('coffee.egresses._dropdown')
                                </td>
                                <td>
                                    {{ $egress->folio }}
                                </td>
                                <td>{{ $egress->provider->name }}</td>
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$  {{ number_format($egress->amount, 2) }}</td>
                                <td align="center">
                                    @if($egress->status == 'pagado')
                                        {{ $egress->mfolio }} <br>
                                        {{ fdate($egress->payment_date, 'd M Y', 'Y-m-d') }}
                                        {{-- <modal id="ppdf{{ $egress->id}}" title="Pago (pdf)">
                                            <iframe src="{{ Storage::url($egress->pdf_payment) }}#view=FitH" width="100%" height="600"></iframe>
                                        </modal> --}}
                                        {{-- @if($egress->pdf_payment)
                                            <modal-button target="ppdf{{ $egress->id}}">
                                                <button class="btn btn-danger btn-xs"><i class="fa fa-file-pdf-o"></i></button>
                                            </modal-button>
                                        @endif --}}
                                    @endif
                                </td>
                                <td align="center">
                                    {!! $egress->status_label !!}
                                </td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
