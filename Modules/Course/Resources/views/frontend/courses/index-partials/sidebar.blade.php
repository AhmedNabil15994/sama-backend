<div class="col-md-3">
  <div class="content-sidebar">
    <h4 class="widget-title filter-res"> {{__('Courses filter')}}</h4>
    <div class="panel-group filter-options" id="accordionNo">
      <div class="btn-save-filter text-left">
        <button class="btn btn-them main-custom-btn">
          {{__('catalog::frontend.category_products.filter.save')}}
        </button>
      </div>
      {!! Form::open(['method'=>'GET','id' => 'filter_form'])!!}
      @if(count($mainCategories))
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title"><a data-toggle="collapse" href="#collapseColor" class="collapseWill">
              {{__('filter by category')}}
              <span class="colles-block"></span> </a></h4>
        </div>
        <div id="collapseColor" class="panel-collapse collapse show">
          <div class="panel-body">
            <div class="checkboxes one-in-row">
              @foreach($mainCategories as $k => $cat)
              <input id="check-category-{{ $cat->id }}" type="checkbox" name="categories[]" {{ !empty(request()->get('categories')) &&
              in_array($cat->id , (array)request()->get('categories')) ? 'checked': '' }}
              value="{{$cat->id}}"
              >
              <label for="check-category-{{ $cat->id }}"> {{ $cat->title }}</label>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      @endif


      {{-- <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title"><a data-toggle="collapse" href="#collapseColor" class="collapseWill">
              {{__('filter by gender')}}
              <span class="colles-block"></span> </a></h4>
        </div>
        <div id="collapseColor" class="panel-collapse collapse show">
          <div class="panel-body">
            <div class="checkboxes one-in-row">
              @foreach(__('course::dashboard.courses.form.genderTypes') as $key=>$gender)
              <input id="check-gender-{{ $key }}" type="checkbox" name="genders[]" {{ !empty(request()->get('genders')) &&
              in_array($key , (array)request()->get('genders')) ? 'checked': '' }}
              value="{{$key}}"
              >
              <label for="check-gender-{{ $key}}"> {{ $gender }}</label>
              @endforeach
            </div>
          </div>
        </div>
      </div>
 --}}




      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title"><a class="collapseWill" data-toggle="collapse" href="#collapsePrice">
              {{__('filter by price')}} <span class="colles-block"></span> </a></h4>
        </div>
        <div id="collapsePrice" class="panel-collapse collapse show">
          <div class="panel-body">
            <div class="filter-price">
              <div class="filter-options-content">
                <div class="price_slider_wrapper">
                  <div data-label-reasult="" data-min="0" data-max="5000" data-unit="{{ __('apps::frontend.master.kwd') }} " class="slider-range-price"
                    data-value-min="{{ !empty(request()->get('price_from')) ? request()->get('price_from') : '0.00' }}"
                    data-value-max="{{ !empty(request()->get('price_to')) ? request()->get('price_to') : '5000.00' }}">
                  </div>
                  <div class="price_slider_amount">
                    <div style="" class="price_label">
                      <span class="from">
                        {{ __('apps::frontend.master.kwd') }}
                        {{ !empty(request()->get('price_from')) ? request()->get('price_from') : '0.00' }}
                      </span>
                      -<span class="to">
                        {{ __('apps::frontend.master.kwd') }}
                        {{ !empty(request()->get('price_to')) ? request()->get('price_to') : '5000.00' }}
                      </span>
                    </div>
                  </div>
                  <div id="hiddenPriceSliderAmount">
                    <input type="hidden" id="priceFrom" name="price_from"
                      value="{{ !empty(request()->get('price_from')) ? request()->get('price_from') : '0.00' }}">
                    <input type="hidden" id="priceTo" name="price_to" value="{{ !empty(request()->get('price_to')) ? request()->get('price_to') : '5000.00' }}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <button type="submit" class="btn btn-them main-custom-btn" style="width: 100%; margin-bottom: 10px;background-color: black"
        href="{{route('frontend.courses' , !empty($category) ? $category->slug : null)}}">
        <i class="fa fa-filter"></i>
        {{__('filter')}}
      </button>

      <a class="btn btn-them secondary-custom-btn" style="    width: 100%;" href="{{route('frontend.courses' , !empty($category) ? $category->slug : null)}}">
        {{__('clear')}}
      </a>

      {!! Form::close()!!}
    </div>
  </div>
</div>
