@extends('apps::dashboard.layouts.app')
@section('title', __('exam::dashboard.exams.routes.index'))
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
                    <a href="#">{{__('exam::dashboard.exams.routes.index')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    @can('add_exams')
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('dashboard.exams.create')) }}"
                                        class="btn sbold green">
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
                                    <a href="javascript:;"
                                        class="collapse"
                                        data-original-title=""
                                        title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter"
                                            class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.date_range')}}
                                                            </label>
                                                            <div id="reportrange"
                                                                class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden"
                                                                    name="from">
                                                                <input type="hidden"
                                                                    name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <div class="form-group">
                                                      <label class="control-label">
                                                        {{__('order::dashboard.orders.datatable.trainer')}}
                                                      </label>
                                                      <select name="trainer_id"
                                                              id="single"
                                                              class="form-control select2">
                                                        <option value="">
                                                          {{__('apps::dashboard.datatable.form.select')}}
                                                        </option>
                                                        @inject('trainers','Modules\Trainer\Entities\Trainer')
                                                        @foreach ($trainers->get() as $trainer)
                                                          <option value="{{ $trainer['id'] }}"
                                                                  @if(request('trainer_id')==$trainer['id'])
                                                                    selected
                                                            @endif>
                                                            {{ $trainer->name }}
                                                          </option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                  </div>
                                                    <div class="col-md-3">
                                                    <div class="form-group">
                                                      <label class="control-label">
                                                        {{__('order::dashboard.orders.datatable.courses')}}
                                                      </label>
                                                      <select name="course_id"
                                                              id="single"
                                                              class="form-control select2">
                                                        <option value="">
                                                          {{__('apps::dashboard.datatable.form.select')}}
                                                        </option>

                                                      </select>
                                                    </div>
                                                  </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.soft_deleted')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::dashboard.datatable.form.delete_only')}}
                                                                    <input type="radio"
                                                                        value="only"
                                                                        name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                id="search">
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
                                {{__('exam::dashboard.exams.routes.index')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;"
                                            onclick="CheckAll()">
                                            {{__('apps::dashboard.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('exam::dashboard.exams.datatable.title')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.trainer')}}</th>
                                    <th>{{__('course::dashboard.coursereviews.datatable.course')}}</th>
                                    <th>{{__('exam::dashboard.exams.datatable.created_at')}}</th>
                                    <th>{{__('exam::dashboard.exams.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit"
                                id="deleteChecked"
                                class="btn red btn-sm"
                                onclick="deleteAllChecked('{{ url(route('dashboard.exams.deletes')) }}')">
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
    function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('dashboard.exams.datatable')) }}",
              type  : "GET",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	          , className: 'dt-center'},
      			{data: 'id' 		 	      , className: 'dt-center'},
            {data: 'title' 			      , className: 'dt-center'},
            {data: 'trainer' 			      , className: 'dt-center'},
            {data: 'course' 			      , className: 'dt-center'},

            {data: 'created_at' 		  , className: 'dt-center'},
            {data: 'id'},
      		],
          columnDefs: [

            {
              targets: -1,
responsivePriority:1,
              width: '13%',
              title: '{{__('exam::dashboard.exams.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                // Edit
      					var editUrl = '{{ route("dashboard.exams.edit", ":id") }}';
      					editUrl = editUrl.replace(':id', data);

      					// Delete
      					var deleteUrl = '{{ route("dashboard.exams.destroy", ":id") }}';
      					deleteUrl = deleteUrl.replace(':id', data);

      					return `
                @can('edit_exams')
      						<a href="`+editUrl+`" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>
      					@endcan

                @can('delete_exams')
                @csrf
                  <a href="javascript:;" onclick="deleteRow('`+deleteUrl+`')" class="btn btn-sm red">
                    <i class="fa fa-trash"></i>
                  </a>
                @endcan`;
              },
            },
          ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
  				buttons:[
  					{
    						extend: "pageLength",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.pageLength')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
    						extend: "print",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.print')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "pdf",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.pdf')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::dashboard.datatable.excel')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.colvis')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					}
  				]
      });
  }

  jQuery(document).ready(function() {
  	tableGenerate();

    $('select[name="trainer_id"]').on('change',function (){
      let trainer_id = $(this).val();
      $.ajax({
        type:'get',
        url: "{{route('dashboard.exams.getTrainerCourses',['trainer_id'=>":trainer_id"])}}".replace(':trainer_id',trainer_id),
      }).success(function (data){
        $('select[name="course_id"]').empty().select2('destroy');
        $.each(data.courses,function (index,item){
          $('select[name="course_id"]').append('<option value="'+item.id+'">'+item.title+'</option>')
        });
        $('select[name="course_id"]').select2()
        console.log(data)
      }).error(function (data){

      })
    });
  });
</script>

@stop
