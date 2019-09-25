<dropdown icon="cogs" color="{{ $color }}">
    <li>
        <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
            <i class="fa fa-eye"></i> Detalles
        </a>
    </li>
    @if ($ingress->invoice_id)
        <li>
            <a href="{{ $ingress->xml }}" target="_blank">
                <i class="fa fa-file-code"></i> XML
            </a>
        </li>
    @else
        <li>
            <a href="" data-toggle="modal" data-target="#modal-f{{ $ingress->id }}">
                <i class="fa fa-plus"></i> Agregar FI
            </a>
        </li>
    @endif
</dropdown>

<modal title="Lista de productos" id="modal-e{{ $ingress->id }}" color="{{ $color }}">
    <sale-products-list sale="{{ $ingress->id }}" 
        amount="{{ $ingress->amount }}"
        iva="{{ $ingress->iva }}">
    </sale-products-list>
</modal>

{!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}

<modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="{{ $color }}">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {!! Field::number('invoice_id', 
                ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                ['icon' => 'file-invoice']) 
            !!}
        </div>
    </div>
    <input type="hidden" name="sales[]" value="{{ $ingress->id }}">
    <br>
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <file-upload fname="xml" ext="xml" color="danger" bname=" SUBIR XML"></file-upload>
        </div>
    </div>
    


    <template slot="footer">
        {!! Form::submit('Guardar', ['class' => "btn btn-$color pull-right"]) !!}
    </template>
</modal>

{!! Form::close() !!}