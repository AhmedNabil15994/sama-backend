@extends('apps::dashboard.layouts.app')
@section('title', __('coupon::dashboard.coupons.routes.clone'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.coupons.index')) }}">
                            {{__('coupon::dashboard.coupons.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('coupon::dashboard.coupons.routes.clone')}}</a>
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

                                                <li class="">
                                                    <a href="#use" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.use') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#custom" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.custom') }}
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
                                                       class="form-control" data-name="title"
                                                       value="{{$coupon->title}}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.code')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" value="{{$coupon->code}}"
                                                       class="form-control" data-name="code">
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
                                                               onclick="toggleCouponType('value')" {{($coupon->discount_type == "value") ? ' checked ' : ''}}>
                                                        <div class="help-block"></div>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{__('coupon::dashboard.coupons.form.percentage')}}
                                                        <input type="radio" name="discount_type" value="percentage" onclick="toggleCouponType('percentage')"
                                                                {{($coupon->discount_type == "percentage") ? ' checked ' : ''}}>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group discount_type" id="value" style="display: none">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_value')}}
                                                ( {{__('apps::frontend.general.kwd')}} )
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="discount_value"
                                                       value="{{$coupon->discount_value}}" class="form-control"
                                                       data-name="discount_value">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group discount_type" id="percentage" style="display: none">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.discount_percentage')}} %
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="discount_percentage"
                                                       value="{{$coupon->discount_percentage}}" class="form-control"
                                                       data-name="discount_percentage">
                                                <div class="help-block"></div>
                                            </div>

                                            {{--<label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.max_discount_percentage_value')}}
                                            </label>
                                            <div class="col-md-4">
                                                <input type="number" value="{{$coupon->max_discount_percentage_value}}"
                                                       name="max_discount_percentage_value" class="form-control"
                                                       data-name="max_discount_percentage_value">
                                                <div class="help-block"></div>
                                            </div>--}}
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status" {{($coupon->status == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="use">
                                    <div class="col-md-10">


                                        {{--                                    <div class="form-group">--}}
                                        {{--                                        <label class="col-md-2">--}}
                                        {{--                                            {{__('coupon::dashboard.coupons.form.max_users')}}--}}
                                        {{--                                        </label>--}}
                                        {{--                                        <div class="col-md-9">--}}
                                        {{--                                            <input type="number" name="max_users" value="{{$coupon->max_users}}" class="form-control" data-name="max_users">--}}
                                        {{--                                            <div class="help-block"></div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}

                                        {{--                                    <div class="form-group">--}}
                                        {{--                                        <label class="col-md-2">--}}
                                        {{--                                            {{__('coupon::dashboard.coupons.form.user_max_uses')}}--}}
                                        {{--                                        </label>--}}
                                        {{--                                        <div class="col-md-9">--}}
                                        {{--                                            <input type="number" name="user_max_uses" value="{{$coupon->user_max_uses}}" class="form-control" data-name="user_max_uses">--}}
                                        {{--                                            <div class="help-block"></div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.start_at')}}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                           name="start_at" value="{{$coupon->start_at}}"
                                                           data-name="start_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
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
                                                           name="expired_at" value="{{$coupon->expired_at}}"
                                                           data-name="expired_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="custom">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.categories') }}
                                                        <input type="radio" name="coupon_flag" value="categories"
                                                               onclick="toggleCouponFlag('categories')"
                                                                {{ $coupon->flag == 'categories' ? 'checked' : '' }}>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.products') }}
                                                        <input type="radio" name="coupon_flag" value="products" onclick="toggleCouponFlag('products')"
                                                                {{ $coupon->flag == 'products' ? 'checked' : '' }}>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="categoriesSection"
                                             style="{{ $coupon->flag == 'categories' ? 'display: block' : 'display: none' }}">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.categories')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="categories_ids[]" multiple id="single"
                                                        class="form-control select2" data-name="categories_ids[]" data-placeholder="{{ __('coupon::dashboard.coupons.form.all_categories') }}">
                                                    <option value=""></option>
                                                    @foreach ($mainCategories as $category)
                                                        <option value="{{ $category['id'] }}"
                                                                {{ $coupon->categories->contains($category->id) ? 'selected':'' }}>
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="productsSection"
                                             style="{{ $coupon->flag == 'products' ? 'display: block' : 'display: none' }}">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.products')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="products_ids[]" multiple id="single"
                                                        class="form-control select2" data-name="products_ids[]" data-placeholder="{{ __('coupon::dashboard.coupons.form.all_products') }}">
                                                    <option value=""></option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product['id'] }}"
                                                                {{ $coupon->products->contains($product->id) ? 'selected':'' }}>
                                                            {{ $product->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.users')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="user_ids[]" multiple id="couponUsersSelect"
                                                        class="form-control select2 coupon-users-select"
                                                        data-name="user_ids[]" data-placeholder="{{ __('coupon::dashboard.coupons.form.coupon_users_hint') }}">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user['id'] }}"
                                                                {{ $coupon->users->contains($user->id) ? 'selected':'' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.general.add_btn')}}
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

        $('#{{$coupon->discount_type}}').show();
        $('#{{$coupon->flag}}Section').show();

        function toggleCouponType(flag) {
            $('.discount_type').hide();
            $('#' + flag).show();
        }

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
                    break;
            }
        }
    </script>
@endsection
