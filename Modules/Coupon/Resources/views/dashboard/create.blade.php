@extends('apps::dashboard.layouts.app')
@section('title', __('coupon::dashboard.coupons.routes.create'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.coupons.index')) }}">
                            {{__('coupon::dashboard.coupons.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('coupon::dashboard.coupons.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.coupons.store')}}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.general') }}
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}

                                <div class="tab-pane active fade in" id="global_setting">
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.title')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="title"
                                                       class="form-control" data-name="title">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.code')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" class="form-control" data-name="code">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_type')}}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{__('coupon::dashboard.coupons.form.value')}}
                                                        <input type="radio" name="discount_type" value="value"
                                                               onclick="toggleCouponType('value')" checked>
                                                        <div class="help-block"></div>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{__('coupon::dashboard.coupons.form.percentage')}}
                                                        <input type="radio" name="discount_type" value="percentage" onclick="toggleCouponType('percentage')">
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group discount_type" id="value">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_value')}}
                                                ( kwd )
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="discount_value" class="form-control"
                                                       data-name="discount_value">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group discount_type" id="percentage" style="display: none">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_percentage')}} %
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" min="0" max="100" name="discount_percentage"
                                                       class="form-control" data-name="discount_percentage">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <hr>
                                        {!! field()->checkBox('add_dates' , __('coupon::dashboard.coupons.form.add_dates'),null,['onchange' => 'toggleDate(this)',]) !!}

                                        <div id="dates_container" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('coupon::dashboard.coupons.form.start_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date time date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="start_at" data-name="start_at">
                                                        <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                    </div>
                                                    <div class="help-block" style="color: #e73d4a"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('coupon::dashboard.coupons.form.expired_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date time date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="expired_at" data-name="expired_at">
                                                        <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                    </div>
                                                    <div class="help-block" style="color: #e73d4a"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                               
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.buttons.add')}}
                                    </button>
                                
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('scripts')

    <script>

        function toggleCouponFlag(flag) {
            switch (flag) {

                case 'categories':
                    $('#categoriesSection').show();
                    $('#productsSection').hide();
                    break;

                case 'products':
                    $('#categoriesSection').hide();
                    $('#productsSection').show();
                    break;

                case '':
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                default:
                    $('#productsSection').show();
                    break;
            }
        }

        function toggleCouponType(flag) {
            $('.discount_type').hide();
            $('#' + flag).show();
        }

        function toggleDate(el) {

            var checked = $(el).is(':checked');

            if(checked){
                $('#dates_container').show();
            }else {

                $('#dates_container').hide();
            }
        }

    </script>

@endsection
