<?php

namespace Modules\Exam\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Exam\Entities\Exam;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Exam\Entities\UserExam;
use Modules\Exam\Http\Requests\Frontend\UserExamRequest;
use Modules\Exam\Repositories\Api\UserExamRepository;
use Modules\Exam\Transformers\Api\{ExamResource,QuestionResource};
use Modules\Semester\Repositories\Frontend\SemesterRepository;

class ExamController extends ApiController
{
    public $userExamRepository;
    public $semesterRepository;

    public function __construct(UserExamRepository $userExamRepository, SemesterRepository $semesterRepository)
    {
        $this->userExamRepository = $userExamRepository;
        $this->semesterRepository = $semesterRepository;
    }

    public function index($courseId)
    {
        $currentSemester = $this->semesterRepository->currentSemester();
        $exams = Exam::has('questions')->whereHas('lessonContents', fn($q) => $q->active()->whereHas('lesson', fn($q) => $q->where('course_id', $courseId)->semesterId($currentSemester->id)))->get();

        return ExamResource::collection($exams);
    }
    public function show($id)
    {
        $exam = Exam::with('questions')->find($id);
        $questions = $exam->questions()->get();
        $this->userExamRepository->findOrCreateUserExam($id);

        return QuestionResource::collection($questions);
    }

    public function levelTest(UserExamRequest $request, $id)
    {
        return  $this->userExamRepository->create($request->all(), $id);
    }

    public function examResult($id)
    {
        $userExam=UserExam::where('user_id', auth()->id())->with('exam')->findOrFail($id);
        $recommendedCourses=Course::inRandomOrder()->limit(5)->get();

        return view('exam::frontend.exams.show-result', compact('userExam', 'recommendedCourses'));
    }

    public function examRetest($id)
    {
        $userExam = optional(auth()->user()->userExams()->where('exam_id', $id)->first())->delete();
        return $this->response([]);
    }
}
