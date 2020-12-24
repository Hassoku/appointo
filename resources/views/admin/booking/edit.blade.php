<form action="" id="update-form" class="ajax-form">
    @method('PUT')
    @csrf
<div class="row mt-2 mb-3">
    <div class="col-md-4 border-right"> <strong>@lang('app.name')</strong> <br>
        <p class="text-muted"><i class="icon-user"></i> {{ ucwords($booking->user->name) }}</p>
    </div>
    <div class="col-md-4 border-right"> <strong>@lang('app.email')</strong> <br>
        <p class="text-muted"><i class="icon-email"></i> {{ $booking->user->email ?? '--' }}</p>
    </div>
    <div class="col-md-4"> <strong>@lang('app.mobile')</strong> <br>
        <p class="text-muted"><i class="icon-mobile"></i> {{ $booking->user->mobile ? $booking->user->formatted_mobile : '--' }}</p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4"> <strong>@lang('app.booking') @lang('app.date')</strong> <br>
        <div class="form-group">
            <input type="text" class="form-control datepicker" name="booking_date" value="{{ $booking->date_time->format($settings->date_format) }}">
        </div>
    </div>
    <div class="col-sm-4"> <strong>@lang('app.booking') @lang('app.time')</strong> <br>
        <div class="form-group">
            <div class="input-group date time-picker">
                <input type="text" class="form-control" name="booking_time" value="{{ $booking->date_time->format($settings->time_format) }}">
                <span class="input-group-append input-group-addon">
                                <button type="button" class="btn btn-default"><span class="fa fa-clock-o"></span></button>
                            </span>
            </div>
        </div>
    </div>
    <div class="col-sm-4"> <strong>@lang('app.booking') @lang('app.status')</strong> <br>
        <div class="form-group">
            <select name="status" id="booking-status" class="form-control">
                <option value="completed" @if($booking->status == 'completed') selected @endif>@lang('app.completed')</option>
                <option value="pending" @if($booking->status == 'pending') selected @endif>@lang('app.pending')</option>
                <option value="approved" @if($booking->status == 'approved') selected @endif>@lang('app.approved')</option>
                <option value="in progress" @if($booking->status == 'in progress') selected @endif>@lang('app.in progress')</option>
                <option value="canceled" @if($booking->status == 'canceled') selected @endif>@lang('app.canceled')</option>
            </select>
        </div>
    </div>
</div>
    <hr>
<div class="row">
    <div class="col-sm-4"> <strong>@lang('menu.employee')</strong> <br>
        <div class="form-group">
            <select name="employee_id" id="" class="form-control">
                <option value=""> @lang('app.selectEmployee') </option>
                @foreach($employees as $employee)
                    <option
                            @if($employee->id == $booking->employee_id) selected @endif
                    value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-12 mb-2">
        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
               <i class="fa fa-plus"></i> @lang('app.add') @lang('app.item')
            </button>
            <div class="dropdown-menu">
                @foreach($businessServices as $service)
                    <a class="dropdown-item add-item"
                       data-price="{{ $service->discounted_price }}"
                       data-service-id="{{ $service->id }}" href="javascript:;">{{ ucwords($service->name) }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <table class="table table-condensed" id="cart-table">
            <thead class="bg-secondary">
            <tr>
                <th>@lang('app.item')</th>
                <th>@lang('app.unitPrice')</th>
                <th width="120">@lang('app.quantity')</th>
                <th class="text-right">@lang('app.amount')</th>
                <th><i class="icon-settings"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($booking->items as $key=>$item)
                <tr>
                    <td><input type="hidden" name="cart_services[]" value="{{ $item->business_service_id }}">
                        {{ ucwords($item->businessService->name) }}</td>
                    <td><input type="hidden" name="cart_prices[]" class="cart-price-{{ $item->business_service_id }}" value="{{ number_format((float)$item->unit_price, 2, '.', '') }}">{{ $settings->currency->currency_symbol.number_format((float)$item->unit_price, 2, '.', '') }}</td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-default quantity-minus" data-service-id="{{ $item->business_service_id }}"><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" readonly name="cart_quantity[]" data-service-id="{{ $item->business_service_id }}" class="form-control cart-service-{{ $item->business_service_id }}" value="{{ $item->quantity }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default quantity-plus" data-service-id="{{ $item->business_service_id }}"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </td>
                    <td class="text-right cart-subtotal-{{ $item->business_service_id }}">{{ $settings->currency->currency_symbol.number_format((float)($item->businessService->discounted_price  * $item->quantity), 2, '.', '') }}</td>
                    <td>
                        <a href="javascript:;" class="btn btn-danger btn-sm btn-circle delete-cart-row"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    <div class="col-md-6 border-top">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0">@lang('modules.booking.paymentMethod')</td>
                        <td class="border-top-0 "><i class="fa fa-money"></i> {{ $booking->payment_gateway }}</td>
                    </tr>
                    <tr class="h6">
                        <td>@lang('modules.booking.paymentStatus')</td>
                        <td><div class="form-group">
                                <select name="payment_status" id="payment-status" class="form-control select2">
                                    <option value="completed" @if($booking->payment_status == 'completed') selected @endif>@lang('app.completed')</option>
                                    <option value="pending" @if($booking->payment_status == 'pending') selected @endif>@lang('app.pending')</option>
                                </select>
                            </div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 border-top">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0 text-right w-50">@lang('app.subTotal')</td>
                        <td class="border-top-0" id="cart-sub-total">{{ $settings->currency->currency_symbol.number_format((float)$booking->original_amount, 2, '.', '') }}</td>
                    </tr>

                    <tr class="h6">
                        <td class="text-right">@lang('app.discount')</td>
                        <td><input type="number" id="cart-discount" name="cart_discount" class="form-control" step=".01" min="0" value="{{ $booking->discount_percent }}"></td>
                    </tr>

                    @if($booking->tax_amount > 0)
                    <tr class="h6">
                        <input type="hidden" id="cart-tax" name="cart_tax" value="{{ $booking->tax_percent }}">
                        <td class="text-right">{{ $booking->tax_name.' ('.$booking->tax_percent.'%)' }}</td>
                        <td id="cart-tax-amount">{{ $settings->currency->currency_symbol.number_format((float)$booking->tax_amount, 2, '.', '') }}</td>
                    </tr>
                    @endif
                    <tr class="h5">
                        <td class="text-right">@lang('app.total')</td>
                        <td id="cart-total">{{ $settings->currency->currency_symbol.number_format((float)$booking->amount_to_pay, 2, '.', '') }}
                            <input type="hidden" id="cart-total-input">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mt-2">
                <button class="btn btn-outline-danger delete-row" data-row-id="{{ $booking->id }}" type="button"><i class="fa fa-times"></i> @lang('app.delete') @lang('app.booking')</button>
            </div>
            <div class="mt-2">
                <button type="button" id="update-booking" data-booking-id="{{ $booking->id }}" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.update')</button>
                <div id="cart-item-error" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    $('.datepicker').datetimepicker({
        format: '{{ $date_picker_format }}',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    $('.time-picker').datetimepicker({
        format: '{{ $time_picker_format }}',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    $("#cart-table").on('change', "input[name='cart_quantity[]']", function () {
        let serviceId = $(this).data('service-id');
        let qty = $(this).val();

        updateCartQuantity(serviceId, qty);
    });

    $('#cart-table').on('click', '.quantity-minus', function () {
        let serviceId = $(this).data('service-id');

        let qty = $('.cart-service-'+serviceId).val();
        qty = parseInt(qty)-1;

        if(qty < 1){
            qty = 1;
        }
        $('.cart-service-'+serviceId).val(qty);

        updateCartQuantity(serviceId, qty);
    });

    $('#cart-table').on('click', '.quantity-plus', function () {
        let serviceId = $(this).data('service-id');

        let qty = $('.cart-service-'+serviceId).val();
        qty = parseInt(qty)+1;

        $('.cart-service-'+serviceId).val(qty);

        updateCartQuantity(serviceId, qty);
    });

    function updateCartQuantity(serviceId, qty) {

        let servicePrice = $('.cart-price-'+serviceId).val();

        let subTotal = (parseFloat(servicePrice) * parseInt(qty));

        $('.cart-subtotal-'+serviceId).html("{{ $settings->currency->currency_symbol }}"+subTotal.toFixed(2));

        calculateTotal();
    }

    $('#cart-table').on('click', '.delete-cart-row', function () {
        $(this).closest('tr').remove();
        calculateTotal();
    });

    $('#cart-discount').keyup(function () {
        if ($(this).val() == '') {
            $(this).val(0);
        }
        if ($(this).val() > 100) {
            $(this).val(100);
        }
        calculateTotal();
    });

    $('#cart-tax').change(function () {
        calculateTotal();
    });

    function calculateTotal() {
        let cartTotal = 0;
        let cartSubTotal = 0;
        let cartDiscount = $('#cart-discount').val();
        let cartTax = $('#cart-tax').val();
        let discount = 0;
        let tax = 0;

        $("input[name='cart_prices[]']").each(function( index ) {
            let servicePrice = $(this).val();
            let qty = $("input[name='cart_quantity[]']").eq(index).val();
            cartSubTotal = (cartSubTotal + (parseFloat(servicePrice) * parseInt(qty)));
        });

        $("#cart-sub-total").html("{{ $settings->currency->currency_symbol }}"+cartSubTotal.toFixed(2));

        if(parseFloat(cartDiscount) > 0){
            if(cartDiscount > 100) cartDiscount = 100;

            discount = ((parseFloat(cartDiscount)/100)*cartSubTotal);
        }

        if(parseFloat(cartTax) > 0){
            tax = ((parseFloat(cartTax)/100)*cartSubTotal);
            $('#cart-tax-amount').html("{{ $settings->currency->currency_symbol }}"+tax.toFixed(2));
        }

        cartTotal = (cartSubTotal - discount + tax).toFixed(2);
        $("#cart-total-input").val(cartTotal);
        $("#cart-total").html("{{ $settings->currency->currency_symbol }}"+cartTotal);
        $("#payment-modal-total").html("{{ $settings->currency->currency_symbol }}"+cartTotal);
    }

    $('.add-item').click(function () {
        let serviceId = $(this).data('service-id');
        let serviceName = $(this).html();
        let servicePrice = parseFloat($(this).data('price')).toFixed(2);

        let item = '<tr>\n' +
            '                    <td><input type="hidden" name="cart_services[]" value="'+serviceId+'">\n' +
            '                        '+serviceName+'</td>\n' +
            '                    <td><input type="hidden" name="cart_prices[]" class="cart-price-'+serviceId+'" value="'+servicePrice+'">{{ $settings->currency->currency_symbol }}'+servicePrice+'</td>\n' +
            '                    <td>\n' +
            '                        <div class="input-group">\n' +
            '                            <div class="input-group-prepend">\n' +
            '                                <button type="button" class="btn btn-default quantity-minus" data-service-id="'+serviceId+'"><i class="fa fa-minus"></i></button>\n' +
            '                            </div>\n' +
            '                            <input type="text" readonly name="cart_quantity[]" data-service-id="'+serviceId+'" class="form-control cart-service-'+serviceId+'" value="1">\n' +
            '                            <div class="input-group-append">\n' +
            '                                <button type="button" class="btn btn-default quantity-plus" data-service-id="'+serviceId+'"><i class="fa fa-plus"></i></button>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </td>\n' +
            '                    <td class="text-right cart-subtotal-'+serviceId+'">{{ $settings->currency->currency_symbol }}'+servicePrice+'</td>\n' +
            '                    <td>\n' +
            '                        <a href="javascript:;" class="btn btn-danger btn-sm btn-circle delete-cart-row"><i class="fa fa-times" aria-hidden="true"></i></a>\n' +
            '                    </td>\n' +
            '                </tr>';

        $('#cart-table tbody').append(item);
        calculateTotal();

    });
</script>
