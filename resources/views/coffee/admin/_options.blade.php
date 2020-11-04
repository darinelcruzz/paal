<dropdown icon="cogs" color="{{ $color }}">
    <li>
        <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
            <i class="fa fa-eye"></i> Detalles
        </a>
    </li>
    @if($status != 'efectivo')
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
    @else

        @if ($ingress->invoice_id)
            <li>
                <a href="{{ $ingress->xml }}" target="_blank">
                    <i class="fa fa-file-code"></i> XML
                </a>
            </li>
        @endif

    @endif
</dropdown>

<modal title="Lista de productos" id="modal-e{{ $ingress->id }}" color="{{ $color }}">

    @if($ingress->products)
    <sale-products-list sale="{{ $ingress->id }}" 
        amount="{{ $ingress->amount }}"
        iva="{{ $ingress->iva }}">
    </sale-products-list>

    @else

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 200px;">Descripción</th>
                <th>Precio</th>
                <th>Can</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingress->movements as $movement)
                <tr>
                    <td>{{ $movement->product->description }}</td>
                    <td>$ {{ number_format($movement->price, 2) }}</td>
                    <td style="text-align: center;">{{ $movement->quantity }}</td>
                    <td>$ {{ number_format($movement->discount, 2) }}</td>
                    <td>$ {{ number_format($movement->price * $movement->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            @if($ingress->iva > 0)
                <tr>
                    <td colspan="3"></td>
                    <th>I.V.A.</th>
                    <td>$ {{ number_format($ingress->iva, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="3"></td>
                <th>Total</th>
                <td>$ {{ number_format($ingress->amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    @endif
</modal>

{!! Form::open(['method' => 'POST', 'route' => 'coffee.invoice.create', 'files' => 'true']) !!}

<modal title="Agregar datos de la facturación" id="modal-f{{ $ingress->id }}" color="{{ $color }}">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {!! Field::number('invoice_id', 
                ['label' => 'Agregar FI','tpl' => 'withicon', 'ph' => 'XXXXXXXXX', 'required' => 'true'], 
                ['icon' => 'file-invoice']) 
            !!}
            <input type="hidden" name="thisDate" value="{{ $date }}">
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