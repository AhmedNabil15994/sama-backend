<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Couchbase\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Route;
use Modules\Course\Events\SendMailToCourseTrainer;
use Modules\Course\Http\Requests\Dashboard\ReviewQuestionCommentRequest;
use Modules\Course\Mail\NotifyTrainerNewCommentEmail;
use Modules\Course\Repositories\Frontend\ReviewQuestionRepository;

class ReviewQuestionController extends Controller
{

    public function __construct(
        public ReviewQuestionRepository $reviewQuestionRepository,
    )
    {
    }

    public function storeReviewQuestion($id,ReviewQuestionCommentRequest $request){

        $create = $this->reviewQuestionRepository->addQuestion($request, $id);
        try {
            // fire an event to send mail to trainer
            Mail::to($create->course->trainer->email)->send(new NotifyTrainerNewCommentEmail($create->load('course.trainer')));
//            event(new SendMailToCourseTrainer($create->load('course.trainer')));
        } catch (\Exception $e) {

        }

        if ($create) {
//            return response()->json(['success' => true, 'question' => $create, __('apps::dashboard.messages.created')]);
            $create->refresh();
            return redirect()->back()->with([
                'status'     => __('apps::dashboard.messages.created'),
                'alert'   => 'success',
            ]);
        }

//    return response()->json(['success' => false, 'status'     => __('apps::dashboard.messages.failed')]);
        return redirect()->back()->with([
            'status'     => __('apps::dashboard.messages.failed'),
            'alert'   => 'danger',
        ]);
    }

    public function storeReviewQuestionAnswer($id,Request $request){
        $create = $this->reviewQuestionRepository->addAnswer($request, $id);
        if ($create) {
            $create->refresh();
            return redirect()->back()->with([
                'status'     => __('apps::dashboard.messages.created'),
                'alert'   => 'success',
            ]);
        }
        return redirect()->back()->with([
            'status'     => __('apps::dashboard.messages.failed'),
            'alert'   => 'danger',
        ]);
    }
}
