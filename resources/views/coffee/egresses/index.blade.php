@extends('coffee.root')

@push('pageTitle')
    Egresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Egresos" color="danger" button>

                <data-table example="1">

                    {{ drawHeader('ID', 'folio', 'Proveedor','compra', 'factura', 'I.V.A.', 'total', 'pago', 'estado') }}

                    <template slot="body">
                        @foreach($egresses as $egress)
                            <tr>
                                <td>{{ $egress->id }}</td>
                                <td>{{ $egress->folio }}</td>
                                <td>{{ $egress->provider->name }}</td>
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>
                                    <modal id="pdf{{ $egress->id}}" title="Factura (pdf)">
                                        <iframe src="{{ Storage::url($egress->pdf_bill) }}#view=FitH" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="pdf{{ $egress->id}}">
                                        <button class="btn btn-danger btn-xs" title="FACTURA"><i class="fa fa-file-pdf-o"></i></button>
                                    </modal-button>

                                    <a href="{{ Storage::url($egress->xml) }}" download class="btn btn-primary btn-xs" title="XML">
                                       <i class="fa fa-file-code-o"></i>
                                    </a>

                                    @if($egress->pdf_complement)
                                        <modal id="pdf_complement_{{ $egress->id}}" title="Factura (pdf)">
                                            <iframe src="{{ Storage::url($egress->pdf_complement) }}#view=FitH" width="100%" height="600"></iframe>
                                        </modal>
                                        <modal-button target="pdf_complement_{{ $egress->id}}">
                                            <button class="btn btn-warning btn-xs" title="COMPLEMENTO"><i class="fa fa-file-pdf-o"></i></button>
                                        </modal-button>
                                    @endif
                                </td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$  {{ number_format($egress->amount, 2) }}</td>
                                <td align="center">
                                    @if($egress->pdf_payment)
                                        {{ fdate($egress->payment_date, 'd M Y', 'Y-m-d') }} &nbsp;
                                        <modal id="ppdf{{ $egress->id}}" title="Pago (pdf)">
                                            <iframe src="{{ Storage::url($egress->pdf_payment) }}#view=FitH" width="100%" height="600"></iframe>
                                        </modal>
                                        <modal-button target="ppdf{{ $egress->id}}">
                                            <button class="btn btn-danger btn-xs"><i class="fa fa-file-pdf-o"></i></button>
                                        </modal-button>
                                    @else
                                        <a href="{{ route('coffee.egress.pay', ['egress' => $egress->id]) }}" class="btn btn-success btn-xs pull-left">
                                            <i class="fa fa-upload"></i>&nbsp;&nbsp; SUBIR PDF
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
