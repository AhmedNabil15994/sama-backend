<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Category\Transformers\Api\{CategoryResource,ShowCategoryResource};
use Modules\Slider\Repositories\Api\SliderRepository as Slider;
use Modules\Category\Repositories\Api\CategoryRepository as Category;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Transformers\Api\SliderResource;

class CategoryController extends ApiController
{
    private $category;

    function __construct(Category $category, public Slider $slider)
    {
        if (request()->hasHeader('authorization'))
            $this->middleware('auth:sanctum');

        $this->category = $category;
    }

    public function categories(Request $request)
    {
        $categories =  CategoryResource::collection($this->category->getAllCategories($request));

        return $request->with_slider && $request->with_slider == 1 ? $categories->additional([
            'sliders' => SliderResource::collection($this->slider->getAll($request))
        ]) : $categories;
    }

    public function show(Request $request, $id)
    {
        return $this->response(new ShowCategoryResource($this->category->findById($id)));
    }
}
