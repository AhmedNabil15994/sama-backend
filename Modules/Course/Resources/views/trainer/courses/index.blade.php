@extends('apps::trainer.layouts.app')
@section('title', __('course::dashboard.courses.routes.index'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('trainer.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('course::dashboard.courses.routes.index')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    @can('add_courses')
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('trainer.courses.create')) }}" class="btn sbold green">
                                        <i class="fa fa-plus"></i> {{__('apps::dashboard.buttons.add_new')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::dashboard.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter" enctype="multipart/form-data" class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.soft_deleted')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::dashboard.datatable.form.delete_only')}}
                                                                    <input type="radio" value="only" name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    {{__('apps::dashboard.datatable.form.with_deleted')}}
                                                                    <input type="radio" value="with" name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @include('course::trainer.courses.datatable-filter')
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::dashboard.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::dashboard.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}


                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('course::dashboard.courses.routes.index')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::dashboard.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('course::dashboard.courses.datatable.title')}}</th>
                                    <th>{{__('course::dashboard.courses.datatable.categories')}}</th>
                                    <th>{{__('course::dashboard.courses.datatable.trainer')}}</th>
                                    <th>{{__('course::dashboard.courses.form.price')}}</th>
                                    {{-- <th>{{__('course::dashboard.courses.form.class_time')}}</th> --}}
                                    <th>{{__('course::dashboard.courses.datatable.course_content')}}</th>
                                    <th>{{__('course::dashboard.lessoncontents.form.order')}}</th>
                                    <th>{{__('course::dashboard.courses.datatable.created_at')}}</th>
                                    <th>{{__('course::dashboard.courses.datatable.options')}}</th>


                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                onclick="deleteAllChecked('{{ url(route('trainer.courses.deletes')) }}')">
                                {{__('apps::dashboard.datatable.delete_all_btn')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('trainer.courses.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'title', className: 'dt-center'},
                        {data: 'categories', className: 'dt-center'},
                        {data: 'trainer_id', className: 'dt-center'},
                        {data: 'price', className: 'dt-center'},
                        // {data: 'class_time', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'order', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id',responsivePriority: 1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                          targets: 6,
                          width: '30px',
                          className: 'dt-center',
                          orderable: false,
                          render: function (data, type, full, meta) {
                           let route="{{ route('trainer.lessoncontents.index',['course_id'=>'--']) }}".replace('--',data);
                           console.log(route);
                          return `<a href="` + route + `"
                            class="btn btn-sm blue"
                            title="Edit">
                                 goto
                          </a>
                          `;
                          },
                          },
                        {
                            targets: 3,
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                var html = '';
                                $.each(data , function( key , category ) {
                                    html += '<span class="badge badge-primary"> '+category.title+' </span>';
                                });
                                return html;
                            },
                        },

                        // {
                        //     targets: 4,
                        //     width: '30px',
                        //     className: 'dt-center',
                        //     render: function (data, type, full, meta) {
                        //         if (data === 'loaded') {
                        //             return '<span class="badge badge-success"> {{__('course::dashboard.videos.loaded')}} </span>';
                        //         } else if (data == null){
                        //             return '<span class="badge badge-danger"> {{__('course::dashboard.videos.not_found')}} </span>';
                        //         }else {
                        //             return '<span class="badge badge-warning"> {{__('course::dashboard.videos.loading')}} </span>';
                        //         }
                        //     },
                        // },
                        {
                            targets: -1,
responsivePriority:1,
                            width: '13%',
                            title: '{{__('course::dashboard.courses.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Edit
                                var editUrl = '{{ route("trainer.courses.edit", ":id") }}';
                                editUrl = editUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route("trainer.courses.destroy", ":id") }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                @can('edit_courses')
      						<a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>
      					@endcan

                @can('delete_courses')
                @csrf
                                    <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                    <i class="fa fa-trash"></i>
                  </a>
                @endcan`;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible'
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
</script>

@stop
