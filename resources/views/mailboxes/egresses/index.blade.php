@extends('mailboxes.root')

@push('pageTitle')
    Egresos | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('mbe.egress.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Egresos" color="success" button>

                <data-table example="1">

                    {{ drawHeader('ID', 'Proveedor','compra', 'factura', 'I.V.A.', 'total', 'fecha pago', 'PDF pago', 'estado') }}

                    <template slot="body">
                        @foreach($egresses as $egress)
                            <tr>
                                <td>{{ $egress->id }}</td>
                                <td>{{ $egress->provider->name }}</td>
                                <td>{{ fdate($egress->buying_date, 'd M Y', 'Y-m-d') }}</td>
                                <td>
                                    <modal id="pdf{{ $egress->id}}" title="Factura (pdf)">
                                        <iframe src="{{ Storage::url($egress->pdf_bill) }}#view=FitH" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="pdf{{ $egress->id}}">
                                        <button class="btn btn-primary btn-xs" title="FACTURA"><i class="fa fa-file-pdf-o"></i></button>
                                    </modal-button>

                                    <a href="{{ Storage::url($egress->xml) }}" download class="btn btn-default btn-xs" title="XML">
                                       <i class="fa fa-file-code-o"></i>
                                    </a>

                                    <modal id="pdf_complement_{{ $egress->id}}" title="Factura (pdf)">
                                        <iframe src="{{ Storage::url($egress->pdf_complement) }}#view=FitH" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="pdf_complement_{{ $egress->id}}">
                                        <button class="btn btn-warning btn-xs" title="COMPLEMENTO"><i class="fa fa-file-pdf-o"></i></button>
                                    </modal-button>
                                </td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$  {{ number_format($egress->amount, 2) }}</td>
                                <td>
                                    {{ fdate($egress->payment_date, 'd M Y', 'Y-m-d') }}
                                </td>
                                <td align="center">
                                    @if($egress->pdf_payment)
                                        <modal id="ppdf{{ $egress->id}}" title="Pago (pdf)">
                                            <iframe src="{{ Storage::url($egress->pdf_payment) }}#view=FitH" width="100%" height="600"></iframe>
                                        </modal>
                                        <modal-button target="ppdf{{ $egress->id}}">
                                            <button class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button>
                                        </modal-button>
                                    @else
                                        <a href="{{ route('mbe.egress.pay', ['egress' => $egress->id]) }}" class="btn btn-success btn-xs">
                                            PAGAR &nbsp;<i class="fa fa-dollar"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
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
