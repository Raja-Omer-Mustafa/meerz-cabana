<div class="ticket packing-slip-ticket">
    <p class="centered headings">
        @lang('lang_v1.packing_slip')
    </p>

    <div class="border-top textbox-info">
        @if(!empty($receipt_details->invoice_no_prefix))
            <p class="f-left"><strong>{!! $receipt_details->invoice_no_prefix !!}</strong></p>
        @endif
        <p class="f-right">{{ $receipt_details->invoice_no }}</p>
    </div>

    @if(!empty($receipt_details->table_name) || !empty($receipt_details->table))
        <div class="textbox-info">
            <p class="f-left"><strong>
                @if(!empty($receipt_details->table_label))
                    {!! $receipt_details->table_label !!}
                @else
                    @lang('restaurant.table')
                @endif
            </strong></p>
            <p class="f-right">{{ $receipt_details->table_name ?? $receipt_details->table }}</p>
        </div>
    @endif

    @if(!empty($receipt_details->date_label))
        <div class="textbox-info">
            <p class="f-left"><strong>{{ $receipt_details->date_label }}</strong></p>
            <p class="f-right">{{ $receipt_details->invoice_date }}</p>
        </div>
    @endif

    <table class="border-bottom width-100 table-f-12 packing-slip-lines">
        <thead class="border-bottom-dotted">
            <tr>
                <th class="serial_number">#</th>
                <th class="description">{{ $receipt_details->table_product_label }}</th>
                <th class="quantity text-right">{{ $receipt_details->table_qty_label }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipt_details->lines as $line)
                <tr>
                    <td class="serial_number" style="vertical-align: top;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="description bw">
                        {{ $line['name'] }} {{ $line['product_variation'] }} {{ $line['variation'] }}
                        @if(!empty($line['sub_sku'])), {{ $line['sub_sku'] }} @endif
                        @if(!empty($line['brand'])), {{ $line['brand'] }} @endif
                        @if(!empty($line['product_custom_fields'])), {{ $line['product_custom_fields'] }} @endif
                        @if(!empty($line['sell_line_note']))
                            <br><span class="f-8">{!! $line['sell_line_note'] !!}</span>
                        @endif
                        @if(!empty($line['lot_number']))
                            <br>{{ $line['lot_number_label'] }}: {{ $line['lot_number'] }}
                        @endif
                        @if(!empty($line['product_expiry']))
                            , {{ $line['product_expiry_label'] }}: {{ $line['product_expiry'] }}
                        @endif
                    </td>
                    <td class="quantity text-right" style="vertical-align: top;">
                        {{ $line['quantity'] }} {{ $line['units'] }}
                    </td>
                </tr>
                @if(!empty($line['modifiers']))
                    @foreach($line['modifiers'] as $modifier)
                        <tr>
                            <td class="serial_number">&nbsp;</td>
                            <td class="description bw">
                                {{ $modifier['name'] }} {{ $modifier['variation'] }}
                                @if(!empty($modifier['sub_sku'])), {{ $modifier['sub_sku'] }} @endif
                                @if(!empty($modifier['sell_line_note']))
                                    <span class="f-8">({!! $modifier['sell_line_note'] !!})</span>
                                @endif
                            </td>
                            <td class="quantity text-right">
                                {{ $modifier['quantity'] }} {{ $modifier['units'] }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="textbox-info" style="page-break-inside: avoid;">
        <p class="f-left"><strong>@lang('lang_v1.authorized_signatory')</strong></p>
    </div>

    @if($receipt_details->show_barcode)
        <div class="centered" style="margin-top: 8px;">
            <img class="packing-slip-barcode" src="data:image/png;base64,{{ DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2, 30, [39, 48, 54], true) }}" alt="">
        </div>
    @endif

    @if(!empty($receipt_details->footer_text))
        <p class="centered" style="margin-top: 8px;">
            {!! $receipt_details->footer_text !!}
        </p>
    @endif
</div>

<style type="text/css">
.packing-slip-ticket {
    width: 100%;
    max-width: 80mm;
    margin: 0 auto;
    color: #000000;
}

.packing-slip-ticket p {
    margin-bottom: 0;
}

.packing-slip-ticket .headings {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.packing-slip-ticket .border-top {
    border-top: 1px solid #242424;
}

.packing-slip-ticket .border-bottom {
    border-bottom: 1px solid #242424;
}

.packing-slip-ticket .border-bottom-dotted {
    border-bottom: 1px dotted darkgray;
}

.packing-slip-ticket .textbox-info {
    clear: both;
    overflow: hidden;
}

.packing-slip-ticket .textbox-info p {
    width: 50%;
    margin-bottom: 0;
}

.packing-slip-ticket .f-left {
    float: left;
    text-align: left;
}

.packing-slip-ticket .f-right {
    float: right;
    text-align: right;
}

.packing-slip-ticket .centered {
    text-align: center;
}

.packing-slip-ticket .text-right {
    text-align: right;
}

.packing-slip-ticket .width-100 {
    width: 100%;
}

.packing-slip-ticket .table-f-12 th,
.packing-slip-ticket .table-f-12 td {
    font-size: 12px;
    word-break: break-word;
    padding: 2px 0;
}

.packing-slip-ticket .packing-slip-lines {
    margin-top: 8px;
    border-collapse: collapse;
}

.packing-slip-ticket td.serial_number,
.packing-slip-ticket th.serial_number {
    width: 8%;
    max-width: 8%;
}

.packing-slip-ticket td.description,
.packing-slip-ticket th.description {
    width: 62%;
    max-width: 62%;
}

.packing-slip-ticket td.quantity,
.packing-slip-ticket th.quantity {
    width: 30%;
    max-width: 30%;
}

.packing-slip-ticket .bw {
    word-break: break-word;
}

.packing-slip-ticket .f-8 {
    font-size: 10px;
}

.packing-slip-ticket .packing-slip-barcode {
    display: block;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
}

@page {
    size: 3.1in auto;
    margin: 2mm 1mm;
}

@media print {
    .packing-slip-ticket,
    .packing-slip-ticket * {
        font-size: 12px;
        font-family: 'Times New Roman', serif;
        color: #000000 !important;
    }

    .packing-slip-ticket {
        width: 100%;
        max-width: 100%;
    }

    .packing-slip-ticket .headings {
        font-size: 14px;
    }

    .packing-slip-ticket .f-8 {
        font-size: 10px !important;
    }

    .packing-slip-ticket .table-f-12 th,
    .packing-slip-ticket .table-f-12 td {
        font-size: 12px;
    }
}
</style>
