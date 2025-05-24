<?php

namespace Modules\Category\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class ShowCategoryController extends Controller
{
//    public function __invoke(Category $category)
//    {
//        if (count($category->children)) {
//            return view('category::frontend.categories.show', ['category' => $category->load('children')]);
//        }
//
//        if (count($category->courses)) {
//            $courses = $category->courses()->active()->orderBy('order','asc')->get();
//            return view('category::frontend.categories.courses-show', ['category' => $category, 'courses' => $courses]);
//        } elseif (count($category->packages)){
//            $packages = $category->packages()->active()->get();
//            return view('category::frontend.categories.packages-show', ['category' => $category, 'packages' => $packages]);
//        }elseif (count($category->notes)) {
//            $notes = $category->notes()->active()->get();
//            return view('category::frontend.categories.notes-show', ['category' => $category, 'notes' => $notes]);
//        }
//
//        return view('category::frontend.categories.no-show', ['category' => $category]);
//    }


    public function __invoke(Category $category)
    {
        if ($category->category_id == null) {
            return view('category::frontend.categories.show', ['category' => $category->load('children')]);
        }

        if (request('type')) {
            if (request('type') == 'courses') {
                $courses = $category->courses()->active()->orderBy('order','asc')->get();
                return view('category::frontend.categories.courses-show', ['category' => $category, 'courses' => $courses]);
            } elseif (request('type') == 'packages'){
                $packages = $category->packages()->active()->get();
                return view('category::frontend.categories.packages-show', ['category' => $category, 'packages' => $packages]);
            }elseif (request('type') == 'notes') {
                $notes = $category->notes()->active()->get();
                return view('category::frontend.categories.notes-show', ['category' => $category, 'notes' => $notes]);
            }

            return view('category::frontend.categories.no-show', ['category' => $category]);
        }
        return view('category::frontend.categories.show-static', ['category' => $category->load('children')]);
//        return view('category::frontend.categories.stage-show', ['category' => $category->load('courses', 'notes', 'packages')]);
    }
}
