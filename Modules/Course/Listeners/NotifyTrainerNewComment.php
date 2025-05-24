<?php

namespace Modules\Course\Listeners;

use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyTrainerNewComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        Mail::send([], [], function (Message $message) use ($event) {
            $url = route('frontend.courses.show', $event->reviewQuestion->course->slug) . '?lesson-content-id=' . $event->reviewQuestion->lesson_content_id;
            logger('Email Comment', [$event->reviewQuestion]);
            $message->to($event->reviewQuestion->course->trainer->email)
                ->subject(' مرحبا لديك تعليق جديد علي مادة ' . $event->reviewQuestion->course->title)
                ->html('<p> :  يمكنك الرد علي الطالب من خلال الرابط التالي  </p>  <a href="' . $url . '">اضغط هنا</a>');
        });
    }
}
