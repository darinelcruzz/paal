<tr>
    <td>
        {{ $sale->folio }}
    </td>
    <td>
        <dropdown icon="cogs" color="danger">
            <li>
                <a href="" data-toggle="modal" data-target="#modal-e{{ $sale->id }}">
                    <i class="fa fa-eye"></i> Detalles
                </a>
            </li>
            @if ($sale->invoice_id)
                <li>
                    <a href="{{ $sale->xml }}" target="_blank">
                        <i class="fa fa-file-code"></i> XML
                    </a>
                </li>
            @else
                <li>
                    <a href="" data-toggle="modal" data-target="#modal-f{{ $sale->id }}">
                        <i class="fa fa-plus"></i> Agregar FI
                    </a>
                </li>
            @endif
        </dropdown>

        <modal title="Lista de productos" id="modal-e{{ $sale->id }}">
            <sale-products-list sale="{{ $sale->id }}" 
                amount="{{ $sale->amount }}"
                iva="{{ $sale->iva }}">
            </sale-products-list>
        </modal>

        {!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}
        
        <modal title="Agregar datos de la facturación" id="modal-f{{ $sale->id }}" color="#dd4b39">

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    {!! Field::number('invoice_id', 
                        ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                        ['icon' => 'file-invoice']) 
                    !!}
                </div>
            </div>
            <input type="hidden" name="sales[]" value="{{ $sale->id }}">
            <br>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <file-upload fname="xml" ext="xml" color="danger" bname=" SUBIR XML"></file-upload>
                </div>
            </div>
            


            <template slot="footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-danger pull-right']) !!}
            </template>
        </modal>

        {!! Form::close() !!}
    </td>
    
    <td>
        {{ $sale->client->name }}
        <span class="pull-right" style="color: green">{!! $sale->invoice_id ? '<i class="fa fa-check"></i>': '' !!}</span>
    </td>
    <td>
        <span class="label label-{{ $sale->statusColor }}">
            {{ ucfirst($sale->status) }}
        </span>
    </td>
    <td>$ {{ number_format($sale->iva, 2) }}</td>
    <td>$ {{ number_format($sale->amount, 2) }}</td>
</tr>