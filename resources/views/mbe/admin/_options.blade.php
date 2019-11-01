<dropdown icon="cogs" color="{{ $color }}">
    <li>
        <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
            <i class="fa fa-eye"></i> Detalles
        </a>
    </li>
    <li>
        <a href="{{ route('mbe.ingress.ticket', $ingress) }}" target="_blank">
            <i class="fa fa-print" aria-hidden="true"></i> Imprimir
        </a>
    </li>
    @if ($ingress->xml)
        <li>
            <a href="{{ $ingress->xml }}" target="_blank">
                <i class="fa fa-file-code"></i> XML
            </a>
        </li>
    @else
        <li>
            <a href="" data-toggle="modal" data-target="#modal-f{{ $ingress->id }}">
                <i class="fa fa-plus"></i> Agregar XML
            </a>
        </li>
    @endif
</dropdown>

<modal title="Lista de productos" id="modal-e{{ $ingress->id }}" color="{{ $color }}">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 80%;">Descripción</th>
                <th style="text-align: center;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach(unserialize($ingress->products) as $product)
                <tr>
                    <td>{{ App\Product::find($product['i'])->description }}</td>
                    <td style="text-align: center;">{{ $product['q'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</modal>

{!! Form::open(['method' => 'POST', 'route' => ['mbe.invoice.update', $ingress], 'files' => 'true']) !!}

<modal title="Agregar XML" id="modal-f{{ $ingress->id }}" color="{{ $color }}">

    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <file-upload fname="xml" ext="xml" color="primary" bname=" SUBIR XML"></file-upload>
            <input type="hidden" name="thisDate" value="{{ $date }}">
        </div>
    </div>

    <template slot="footer">
        {!! Form::submit('Guardar', ['class' => 'btn btn-success pull-right']) !!}
    </template>
</modal>

{!! Form::close() !!}