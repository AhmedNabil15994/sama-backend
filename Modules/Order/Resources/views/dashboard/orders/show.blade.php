@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('content')

<style type="text/css" media="print">
	@page {
		size  : auto;
		margin: 0;
	}
	@media print {
		a[href]:after {
		content: none !important;
	}
	.contentPrint{
			width: 100%;
		}
		.no-print, .no-print *{
			display: none !important;
		}
	}
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.orders.index')) }}">
                        {{__('order::dashboard.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.orders.show.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#order">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#update">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.update')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" id="order">
                            <div class="invoice-content-2 bordered">

                                <div class="col-md-12" style="margin-bottom: 24px;">
                                    <center>
                                        <img src="{{setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png') }}" class="img-responsive" style="margin-bottom: 25px;width:18%" />
                                        <b>
                                            #{{ $order['id'] }} -
                                            {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }} / {{ $order['type'] }}
                                        </b>
                                    </center>
                                    @if ($order['type'] == 'cash')
                                      <center>{{__('order::dashboard.orders.show.cash_payment')}}</center>
                                    @else
                                      <center>{{ $order->orderStatus->title }}</center>
                                    @endif

                                  @if ($order->user->address)
                                    <div class="course-details__meta-link">
                                      <div class="course-details__meta-icon">
                                        <i class="fas fa-user-circle"></i>
                                      </div>
                                      @lang("Address"):
                                      <span>
                                      @lang($order->user->address->type)
                                        @if($order->user->address->state)
                                          @lang("State")
                                          {{$order->user->address->state->title}}, <br>
                                        @endif
                                        @if($order->user->address->widget)
                                          {{ __('Block') }}
                                          {{$order->user->address->widget}}, <br>
                                        @endif
                                        @if($order->user->address->street)
                                          @lang("Street")
                                          {{$order->user->address->street}}, <br>
                                        @endif
                                        @if($order->user->address->building)
                                          {{ __('House') }}
                                          {{auth()->user()->address->building}}, <br>
                                        @endif
                                        @if($order->user->address->details)
                                          {{$order->user->address->details}}
                                        @endif
                                      </span>
                                    </div>
                                  @endif
                                </div>

                                @if ($order->user)
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.username')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.email')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.mobile')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->user->name }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->email }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.item')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.course_price')}}
                                                    </th>
                                                  <th class="invoice-title uppercase text-center">
                                                    {{__('order::dashboard.orders.datatable.options')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderCourses as $course)
                                                    <tr>
                                                        <td class="text-center sbold">
                                                          <a href="{{route('dashboard.courses.edit',$course->course->id)}}" target="_blank">{{ $course->course->title }}</a>
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $course->total }}
                                                        </td>
                                                      <td class="text-center sbold">
                                                        <button type="button" class="btn btn-lg green change-course-expireDate"  data-toggle="modal" data-target="#changeCourseExpireDateModal_{{$course->id}}">
                                                          {{__('order::dashboard.order_statuses.form.edit_date')}}
                                                        </button>
                                                      </td>
                                                    </tr>


                                                    <div class="modal fade" id="changeCourseExpireDateModal_{{$course->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                      <div class="modal-dialog">
                                                        {!! Form::model($course, [
        'url' => route('orders.change.expire_date.update'),
        'id' => 'updateForm',
        'role' => 'form',
        'method' => 'POST',
        'class' => 'form-horizontal form-row-seperated',
        'files' => false,
        ]) !!}
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">{{__('order::dashboard.expire_date')}}</h4>
                                                          </div>
                                                          <div class="modal-body">
                                                            <input type="hidden" name="type" value="course">
                                                            <input type="hidden" name="id" value="{{$course->id}}">
                                                            {!! field()->dateTime('expired_date', __('order::dashboard.expire_date'),
                                                                $course->expired_date ? \Carbon\Carbon::parse($course->expired_date)->format('Y-m-d H:m'): null) !!}

                                                          </div>
                                                          <div class="row">
                                                            <div class="col-md-12">
                                                              <div class="form-actions">
                                                                @include('apps::dashboard.layouts._ajax-msg')
                                                                <div class="modal-footer">
                                                                  <button type="button" class="btn btn-default" data-dismiss="modal">{{__('order::dashboard.close')}}</button>
                                                                  <button type="submit" id="submit" class="btn btn-lg green">
                                                                    {{__('apps::dashboard.buttons.edit')}}
                                                                  </button>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                      </div>
                                                    </div>
                                                @endforeach

                                                @foreach ($order->orderNotes as $note)
                                                  <tr>
                                                    <td class="text-center sbold">
                                                      <a href="{{route('dashboard.notes.edit',$note->note->id)}}" target="_blank">{{ $note->note->title }}</a>
                                                    </td>
                                                    <td class="text-center sbold">
                                                      {{ $note->total }}
                                                    </td>
                                                  </tr>
                                                @endforeach

                                                @foreach ($order->orderPackages as $package)
                                                  <tr>
                                                    <td class="text-center sbold">
                                                      <a href="{{route('dashboard.packages.edit',$package->package->id)}}" target="_blank">{{ $package->package->title }}</a>
                                                    </td>
                                                    <td class="text-center sbold">
                                                      {{ $package->total }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                      <button type="button" class="btn btn-lg green change-package-expireDate" data-toggle="modal" data-target="#changePackageExpireDateModal_{{$package->id}}">
                                                        {{__('order::dashboard.order_statuses.form.edit_date')}}
                                                      </button>
                                                    </td>
                                                  </tr>

                                                  <div class="modal fade" id="changePackageExpireDateModal_{{$package->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      {!! Form::model($package, [
'url' => route('orders.change.expire_date.update'),
'id' => 'updateForm',
'role' => 'form',
'method' => 'POST',
'class' => 'form-horizontal form-row-seperated',
'files' => true,
]) !!}
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                          <h4 class="modal-title" id="myModalLabel">{{__('order::dashboard.expire_date')}}</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                          <input type="hidden" name="type" value="package">
                                                          <input type="hidden" name="id" value="{{$package->id}}">
                                                          {!! field()->dateTime('expired_date', __('order::dashboard.expire_date'),
                                                              $package->expired_date ? \Carbon\Carbon::parse($package->expired_date)->format('Y-m-d H:m'): null) !!}

                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-actions">
                                                              @include('apps::dashboard.layouts._ajax-msg')
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('order::dashboard.close')}}</button>
                                                                <button type="submit" id="submit" class="btn btn-lg green">
                                                                  {{__('apps::dashboard.buttons.edit')}}
                                                                </button>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        {!! Form::close() !!}
                                                      </div>
                                                    </div>
                                                  </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.subtotal')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.off')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.total')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        {{ $order->subtotal }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->discount }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->total }} {{ setting('default_currency') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                      <div class="tab-pane" id="update">
                        <form id="updateForm" role="form" class="form-horizontal form-row-seperated" method="post"
                              enctype="multipart/form-data"
                              action="{{ route('dashboard.orders.update',$order['id']) }}">
                          @csrf
                          @method('PUT')
                          <div class="form-group">
                            <label class="col-md-2">
                              {{__('order::dashboard.orders.show.status')}}
                              <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-9">
                              <select name="status_id" id="single" class="form-control select2" data-name="status_id">
                                <option value=""></option>
                                @foreach ($statuses as $status)
                                  <option
                                    value="{{ $status['id'] }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->title }}
                                  </option>
                                @endforeach
                              </select>
                              <div class="col-md-9">
                                <div class="help-block"></div>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                  <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                  </button>
                                  <a href="{{url(route('dashboard.orders.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });
</script>

@stop
