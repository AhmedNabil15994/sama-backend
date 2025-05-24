<?php
namespace Modules\Course\Repositories\Trainer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Modules\Course\Entities\LessonContent;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Course\Entities\Video;
class LessonContentRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(LessonContent::class);
        $this->fileAttribute = ['resource' => 'resources'];
    }
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->type !== 'exam') {
            Arr::pull($data, 'exam_id', null);
        }
        return $data;
    }
    public function modelUpdated($model, $request): void
    {
        if ($request['type'] == 'resource') {
            $this->restExam($model);
        }
        if ($request['type'] == 'exam') {
            $this->restResource($model);
        }
    }
    public function restVideo($model)
    {
        //todoList implement  function to delete video from database and video service
    }
    public function restExam($model)
    {
        $model->update(['exam_id' => null]);
    }
    public function restResource($model)
    {
        $model->clearMediaCollection('resources');
    }
    public function appendFilter(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query->when(
            request('req.course_id'),
            fn ($q) =>  $q->whereHas('lesson', fn ($q) => $q->where('course_id', request('req.course_id')))
        )->when(
            request('req.lesson_id'),
            fn ($q, $v) => $q->where('lesson_id', request('req.lesson_id'))
        )->when(
            data_get($request, 'req.semester_id'),
            fn ($q) =>  $q->whereHas('lesson', fn ($q) => $q->where('semester_id', request('req.semester_id')))
        );
    }

    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        $userId = auth()->user()->id;
        if($userId){
            $query = $query->whereHas('lesson',function($whereQ) use ($userId){
                $whereQ->whereHas('course',function ($course) use ($userId){
                    $course->trainer($userId);
                });
            });
        }
        return $query;
    }
    /**
     * when to delete video
     * case 1 we have another one
     * case 2 we have another type
     */
    /**
     * when to reset exam_id
     * case 1 we have another type
     */
    /**
     * when to reset resource
     * case 1 we have another type
     */
}
