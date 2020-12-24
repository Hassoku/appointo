@forelse($customers as $customer)
    <div class="col-md-3">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user customer-card" onclick="location.href='{{ route('admin.customers.show', $customer->id) }}'">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white" style="background-color: var(--active-color)">
                <h5 class="widget-user-username">{{ ucwords($customer->name) }}</h5>
                <h6 class="widget-user-desc"><i class="fa fa-envelope"></i> {{ $customer->email ?? '--' }}</h6>
                <h6 class="widget-user-desc"><i class="fa fa-phone"></i> {{ $customer->mobile ? $customer->formatted_mobile : '--' }}</h6>
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{ $customer->user_image_url }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{ count($customer->completedBookings) }}</h5>
                            <span class="description-text">@lang('menu.bookings')</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">{{ $customer->created_at->format($settings->date_format)  }}</h5>
                            <span class="description-text">@lang('modules.customer.since')</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
@empty
    <div class="col-md-4">
        @lang('messages.noRecordFound')
    </div>
@endforelse

@php
    $loadedRecords = ($totalRecords - ($totalRecords - count($customers)));
    $takeRecords = $recordsLoad + $loadedRecords;
@endphp

@if($totalRecords > $loadedRecords)
    <div class="col-md-12 text-center">
        <a href="javascript:;" data-take="{{ $takeRecords }}" id="load-more" class="btn btn-lg btn-outline-dark">@lang('app.loadMore')</a>
    </div>
@endif
