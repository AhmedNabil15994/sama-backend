@inject('categories', 'Modules\Category\Entities\Category')
@inject('trainers', 'Modules\Trainer\Entities\Trainer')
<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{
      __('course::dashboard.courses.datatable.categories')
      }}
    </label>
    <select name="categories"
      id="single"
      class="form-control select2">
      <option value="">
        {{__('course::dashboard.courses.datatable.categories')}}
      </option>
      @foreach ($categories->active()->get() as $category)
      <option value="{{ $category->id }}">
        {{ $category->title }}
      </option>
      @endforeach
    </select>
  </div>
</div>


<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{__('course::dashboard.courses.form.trainers')}}
    </label>
    <select name="trainer"
      id="single"
      class="form-control select2">
      <option value="">
        {{__('course::dashboard.courses.form.trainers')}}
      </option>
      @foreach ($trainers->get() as $trainer)
      <option value="{{ $trainer->id }}">
        {{ $trainer->name }}
      </option>
      @endforeach
    </select>
  </div>
</div>
