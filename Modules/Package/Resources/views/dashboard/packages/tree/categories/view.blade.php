@foreach ($mainCategories as $category)
  <ul>
    <li id="{{$category->id}}" data-jstree=
    '{"opened":true
        {{ $model->category ? ($model->category->id ==  $category->id ? ',"selected":true' : '') : ''  }}
      }'
    >
      {{$category->title}}
      @if($category->children->count() > 0)
        @include('package::dashboard.packages.tree.categories.view',['mainCategories' => $category->children])
      @endif
    </li>
  </ul>
@endforeach
