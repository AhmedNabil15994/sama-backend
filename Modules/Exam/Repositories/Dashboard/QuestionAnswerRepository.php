<?php

namespace Modules\Exam\Repositories\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionAnswer;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class QuestionAnswerRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(QuestionAnswer::class);
        $this->statusAttribute=[];
        $this->fileAttribute=['image' => 'answers_images'];
    }


    /**
    * Prepare Data before save or edir
    *
    * @param array $data
    * @param \Illuminate\Http\Request $request
    * @param boolean $is_create
    * @return array
    */
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        return parent::prepareData($data, $request, $is_create);
    }


    public function modelCreated($model, $request, $is_created = true): void
    {

    }
    public function modelUpdated($model, $request): void
    {

    }
}
