<?php

namespace Modules\Cart\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Http\Requests\Api\CartRequest;
use Modules\Cart\Transformers\Api\CartResource;
use Modules\Course\Transformers\Frontend\CourseResource;
use Modules\Course\Transformers\Frontend\NoteResource;
use Modules\Package\Transformers\Frontend\CartPackageResource;
use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Modules\Course\Repositories\Frontend\NoteRepository as Note;
use Modules\Package\Repositories\Frontend\PackageRepository as Package;

class CartController extends ApiController
{
    use CartTrait;

    protected $course;
    protected $note;
    protected $package;

    public function __construct(Course $course,Note $note,Package $package)
    {
        $this->course = $course;
        $this->note = $note;
        $this->package = $package;
    }

    public function index(Request $request)
    {
        $coursesSubscribed = $this->course->subscribedCourses();
        foreach ($coursesSubscribed as $course) {
            $this->removeItem($course['id'], 'course');
        }

        return $this->cartResponse();
    }

    public function add(CartRequest $request, $id)
    {
        $type = $request->type;
        $item = $this->getItem($id, $type);
        if (is_null($item)) {
            return $this->error('course not found');
        }
        $this->addToCart($item, $type, $request->qty);
        return $this->cartResponse();
    }

    private function cartResponse()
    {
        $items = array_values($this->getCartContent()->toArray());
        
        return $this->response([
            'items' => CartResource::collection($items),
            'total' => number_format($this->cartTotal(),3)
        ]);
    }
    
    private function  getItem($id, $type)
    {
        try {
            switch($type){
                case 'note':
                    $model = $this->note->findNoteById($id);
                    $item = !is_null($model) ? (new NoteResource($model))->jsonSerialize() : null;
                    break;
                case 'course':
                    $model = $this->course->findCourseById($id);
                    $item = !is_null($model) ? (new CourseResource($model))->jsonSerialize() : null;
                    break;
                case 'package':
                    $model = $this->package->findPackageById($id);
                    $item = !is_null($model) ? (new CartPackageResource($model))->jsonSerialize() : null;
                    break;
            }

            return $item;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    public function remove(CartRequest $request, $id)
    {
        $type = $request->type;
        $this->removeItem($id, $type);

        return $this->cartResponse();
    }

    public function clear()
    {
        $this->getCart()->clear();

        return $this->response([]);
    }
}
