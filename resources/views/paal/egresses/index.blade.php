@extends('paal.root')

@push('pageTitle')
    Egresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Egresos" color="primary" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'empresa', 'compra', 'I.V.A.', 'total', 'pago', 'estado') }}

                    <template slot="body">
                        @foreach($egresses as $egress)
                            <tr>
                                <td>{{ $egress->id }}</td>
                                <td>
                                    {{ strtoupper($egress->company) }}
                                    &nbsp;&nbsp;
                                    <a style="color: black;" href="{{ route('paal.egress.cancel', ['id' => $egress->id]) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    {{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}
                                    &nbsp;&nbsp;
                                    <modal id="pdf{{ $egress->id}}" title="Factura (.PDF)">
                                        <iframe src="{{ Storage::url($egress->pdf_bill) }}#view=FitH" width="100%" height="600"></iframe>
                                    </modal>
                                    <modal-button target="pdf{{ $egress->id}}">
                                        <a href="" style="color: red;"><i class="fa fa-file-pdf-o"></i></a>
                                    </modal-button>
                                    &nbsp;
                                    <a href="{{ Storage::url($egress->xml) }}" download title="FACTURA XML">
                                       <i class="fa fa-file-code-o"></i> 
                                    </a>
                                </td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$ {{ number_format($egress->amount, 2) }}</td>
                                <td>
                                    @if($egress->pdf_payment)
                                        {{ fdate($egress->payment_date, 'd M Y', 'Y-m-d') }}
                                        &nbsp;&nbsp;
                                        <modal id="ppdf{{ $egress->id}}" title="Pago (pdf)">
                                            <iframe src="{{ Storage::url($egress->pdf_payment) }}#view=FitH" width="100%" height="600"></iframe>
                                        </modal>
                                        <modal-button target="ppdf{{ $egress->id}}">
                                            <a href="" style="color: red;"><i class="fa fa-file-pdf-o"></i></a>
                                        </modal-button>
                                    @else
                                        {!! Form::open([
                                            'method' => 'POST', 
                                            'route' => ['paal.egress.settle', $egress->id], 
                                            'enctype' => 'multipart/form-data'
                                            ]) 
                                        !!}
                                            <pdf-button fname="pdf_payment" ext="pdf" color="default"></pdf-button>
                                            <input type="hidden" name="id" value="{{ $egress->id }}">
                                            <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-check"></i></button>
                                        {!! Form::close() !!}
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