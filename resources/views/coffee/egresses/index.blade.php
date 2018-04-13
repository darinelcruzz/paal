@extends('lte.root')

@push('pageTitle')
    PAAL | Egresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Egresos" color="success" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'compra', 'factura', 'I.V.A.', 'total', 'fecha pago', 'PDF', 'estado') }}

                    <template slot="body">
                        @foreach($egresses as $egress)
                            <tr>
                                <td>{{ $egress->id }}</td>
                                <td>{{ fdate($egress->buying_date, 'd M Y', 'Y-m-d') }}</td>
                                <td>
                                    <modal id="pdf{{ $egress->id}}" title="Factura (pdf)">
                                        <iframe src="{{ Storage::url($egress->pdf_bill) }}#view=FitH" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="pdf{{ $egress->id}}">
                                        <button class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button>
                                    </modal-button>

                                    <modal id="xml{{ $egress->id}}" title="Factura (xml)">
                                        <iframe src="{{ Storage::url($egress->xml) }}" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="xml{{ $egress->id}}">
                                        <button class="btn btn-default btn-xs"><i class="fa fa-file-code-o"></i></button>
                                    </modal-button>
                                </td>
                                <td>{{ $egress->iva}} %</td>
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
                                        {!! Form::open(['method' => 'POST', 'route' => 'egress.upload', 'enctype' => 'multipart/form-data']) !!}
                                            <pdf-button fname="pdf_payment" ext="pdf" color="default"></pdf-button>
                                            <input type="hidden" name="id" value="{{ $egress->id }}">
                                            <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                                <td>
                                    <span class="label label-{{ $egress->status != 'pendiente' ? 'success': 'danger'}}">
                                        {{ ucfirst($egress->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection