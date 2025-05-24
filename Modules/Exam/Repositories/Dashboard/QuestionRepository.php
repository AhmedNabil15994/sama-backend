<?php

namespace Modules\Exam\Repositories\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionAnswer;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Exam\Repositories\Dashboard\QuestionAnswerRepository as QuestionRepo;

class QuestionRepository extends CrudRepository
{
    private $question_answer;
    public function __construct()
    {
        parent::__construct(Question::class);
        $this->statusAttribute=[];
        $this->fileAttribute=['audio'=>'audio','image' => 'images'];
        $this->question_answer = new QuestionRepo();
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
        if ($request->with_file=='on') {
            $data['type']='audio';
        } else {
            $removeAudioFromRequest=Arr::pull($data, 'audio');
            $data['type']='question';
        }
        return parent::prepareData($data, $request, $is_create);
    }


    public function modelCreated($model, $request, $is_created = true): void
    {
        $this->createAnswers($model, $request->answers);
    }
    public function modelUpdated($model, $request): void
    {
        if ($request->deletedAnswers) {
            $this->deleteManyAnswers($request->deletedAnswers);
        }
        if ($request->answers) {
            $this->createAnswers($model, $request->answers);
        }
        if ($request->old_answers) {
            foreach ($request->old_answers as $key => $value) {
                $value['is_correct'] = isset($value['is_correct']) ? ($value['is_correct'] == 1 ? 1 : 0) : 0;
                $answer_request = new \Illuminate\Http\Request();
                $answer_request->replace(['answer' => $value['answer'], 'degree' => $value['degree'], 'image' => isset($value['answer_image']) ? [$value['answer_image']] : null, 'question_id' => $model->id, 'is_correct' => $value['is_correct']]);
                $this->question_answer->update($answer_request, $value['id']);
            }
        }

        if ($model->type != 'audio') {
            $model->clearMediaCollection('audio');
        }
    }


    private function createAnswers($model, $answers)
    {
        if($answers){
//            $model->answers()->createMany($answers);
            foreach ($answers as $key => $value) {
                $value['is_correct'] = isset($value['is_correct']) ? ($value['is_correct'] == 1 ? 1 : 0) : 0;
                $answer_request = new \Illuminate\Http\Request();
                $answer_request->replace(['answer' => $value['answer'], 'degree' => $value['degree'], 'image' => isset($value['answer_image']) ? [$value['answer_image']] : null, 'question_id' => $model->id, 'is_correct' => $value['is_correct']]);
                $this->question_answer->create($answer_request);
            }
        }
    }
    private function deleteManyAnswers($deletedAnswers)
    {
        foreach ($deletedAnswers as  $id) {
            $this->question_answer->delete($id);
        }
    }
}
