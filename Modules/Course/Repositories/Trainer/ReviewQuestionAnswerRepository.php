<?php

namespace Modules\Course\Repositories\Trainer;

use Illuminate\Http\Request;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Course\Entities\ReviewQuestionAnswer;

class ReviewQuestionAnswerRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(ReviewQuestionAnswer::class);
    }


    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        return $query;
    }
}
