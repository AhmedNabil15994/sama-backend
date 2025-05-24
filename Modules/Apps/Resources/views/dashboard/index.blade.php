@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@section('css')
<style>
    .mb-25{
      margin-bottom: 25px !important;
    }
</style>
@endsection
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

            @can('show_statistics')

{{--                 DATATABLE FILTER--}}
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">
                                {{__('apps::dashboard.datatable.form.date_range')}}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="filter_data_table">
                            <div class="panel-body">
                                <form class="horizontal-form">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <div id="reportrange" class="btn default form-control">
                                                        <i class="fa fa-calendar"></i> &nbsp;
                                                        <span> </span>
                                                        <b class="fa fa-angle-down"></b>
                                                        <input type="hidden" name="from">
                                                        <input type="hidden" name="to">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions col-md-3">

                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                        type="submit">
                                                    <i class="fa fa-search"></i>
                                                    {{__('apps::dashboard.datatable.search')}}
                                                </button>
                                                <a class="btn btn-sm red btn-outline filter-cancel"
                                                   href="{{url(route('dashboard.home'))}}">
                                                    <i class="fa fa-times"></i>
                                                    {{__('apps::dashboard.datatable.reset')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
{{--                 END DATATABLE FILTER--}}

                <div class="row">
                    <div class="portlet light bordered col-lg-12">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 blue"
                               href="{{url(route('dashboard.courses.index'))}}">

                                <div class="visual">
                                  <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['coursesCount']}}">{{$data['coursesCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.courses') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 red"
                               href="{{url(route('dashboard.notes.index'))}}">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['notesCount']}}">{{$data['notesCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.notes') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 orange"
                               href="{{url(route('dashboard.packages.index'))}}">

                                <div class="visual">
                                  <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['packagesCount']}}">{{$data['packagesCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.packages') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 green"
                               href="{{url(route('dashboard.orders.index'))}}">

                                <div class="visual">
                                  <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['examsCount']}}">{{$data['examsCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.exams') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                          <a class="dashboard-stat dashboard-stat-v2 green"
                             href="{{url(route('dashboard.trainers.index'))}}">

                            <div class="visual">
                              <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                              <div class="number">
                                <span data-counter="counterup" data-value="{{$data['trainersCount']}}">{{$data['trainersCount']}}</span>
                              </div>
                              <div class="desc">{{ __('apps::dashboard.index.statistics.trainers') }}</div>
                            </div>
                          </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                          <a class="dashboard-stat dashboard-stat-v2 green"
                             href="{{url(route('dashboard.users.index'))}}">

                            <div class="visual">
                              <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                              <div class="number">
                                <span data-counter="counterup" data-value="{{$data['usersCount']}}">{{$data['usersCount']}}</span>
                              </div>
                              <div class="desc">{{ __('apps::dashboard.index.statistics.users') }}</div>
                            </div>
                          </a>
                        </div>
                    </div>

                    <div class="portlet light bordered col-lg-12">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-bubbles font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">
                                {{__('apps::dashboard.index.statistics.titles.orders')}}
                            </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 label-warning"
                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['pendingOrdersCount']}}">{{$data['pendingOrdersCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.pending_orders') }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 green-dark"
                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['completedOrdersCount']}}">{{$data['completedOrdersCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.completed_orders') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 label-primary"
                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['totalOrdersCount']}}">{{$data['totalOrdersCount']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_orders') }}</div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="portlet light bordered col-lg-12">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-bubbles font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">
                                {{__('apps::dashboard.index.statistics.profit')}}
                            </span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="{{url(route('dashboard.transactions.index'))}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['total_profit']}}">{{$data['total_profit']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_profit') }}</div>
                                </div>
                            </a>
                            <br>
                        </div>
                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.orders.course_orders'))}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['course_orders_total']}}">{{$data['course_orders_total']}}</span> KWD
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.course_orders_profit') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.orders.note_orders'))}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['note_orders_total']}}">{{$data['note_orders_total']}}</span> KWD
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.note_orders_profit') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.orders.package_orders'))}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['package_orders_total']}}">{{$data['package_orders_total']}}</span> KWD
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.package_orders_profit') }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            @endcan
        </div>
    </div>

@stop
@section('scripts')
  @include('apps::dashboard.layouts._js')
@endsection
