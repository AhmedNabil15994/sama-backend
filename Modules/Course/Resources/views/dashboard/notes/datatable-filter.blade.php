@inject('categories', 'Modules\Category\Entities\Category')
@inject('trainers', 'Modules\Trainer\Entities\Trainer')
<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{__('course::dashboard.notes.form.is_paper')}}
    </label>
    <div class="mt-radio-list">
      <label class="mt-radio">
        {{__('Yes')}}
        <input type="radio"
          value="1"
          name="is_paper" />
        <span></span>
      </label>
      <label class="mt-radio">
        {{__('No')}}
        <input type="radio"
          value="0"
          name="is_paper" />
        <span></span>
      </label>
    </div>
  </div>
</div>
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
