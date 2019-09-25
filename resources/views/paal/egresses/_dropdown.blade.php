<dropdown color="{{ $color }}" icon="cogs">

	<ddi icon="edit" to="{{ route('paal.egress.edit', $egress) }}" text="Editar folio"></ddi>

	@if($egress->pdf_bill)
        
        <ddi icon="file-pdf-o" to="pdf{{ $egress->id}}" text="Ver factura" :datatarget="true"></ddi>

    @else

    	<ddi icon="upload" to="{{ route('paal.egress.replace', $egress) }}" text="Subir factura"></ddi>

    @endif

    @if($egress->xml)
	    <ddi icon="file-code-o" to="{{ Storage::url($egress->xml) }}" text="XML" download="{{ $egress->folio }}"></ddi>
	@endif   

    @if ($egress->status != 'pagado')
        <ddi icon="usd" to="{{ route('paal.egress.pay', $egress) }}" text="Pagar"></ddi>
    @endif

    @if($egress->pdf_payment)
        <ddi icon="file-pdf-o" to="ppdf{{ $egress->id}}" text="Ver pago" :datatarget="true"></ddi>
    @endif

    @if($egress->pdf_complement)

        <ddi icon="file-pdf-o" to="pdf_complement_{{ $egress->id}}" text="Ver complemento" :datatarget="true"></ddi>

    @endif

</dropdown>


@if($egress->pdf_bill)
        
    <modal id="pdf{{ $egress->id}}" title="Factura (pdf)">
	    <iframe src="{{ Storage::url($egress->pdf_bill) }}#view=FitH" width="100%" height="600"></iframe>
	</modal>

@endif

@if($egress->pdf_complement)

    <modal id="pdf_complement_{{ $egress->id}}" title="Factura (pdf)">
	    <iframe src="{{ Storage::url($egress->pdf_complement) }}#view=FitH" width="100%" height="600"></iframe>
	</modal>

@endif

@if($egress->pdf_payment)

    <modal id="ppdf{{ $egress->id}}" title="Pago (pdf)">
	    <iframe src="{{ Storage::url($egress->pdf_payment) }}#view=FitH" width="100%" height="600"></iframe>
	</modal>
	
@endif