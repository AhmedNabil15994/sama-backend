<?php

namespace Modules\Course\Repositories\Frontend;

use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\UserVideo;
use Modules\Course\Entities\LessonContent;
use Modules\User\Entities\User;
use Vimeo\Vimeo;

class UserVideoRepository
{
    public function create($request)
    {
        $user_id = request('user_id') ? request('user_id') : auth()->id();
        if ($user_id) {
            $lessonContent = LessonContent::with('video')->find($request->lesson_content_id);
            $video_duration = $request->video_duration;
//        $path = $lessonContent ? parse_url($lessonContent->video_link) : null;
//        if (isset($path['path']) && $path) {
//            $vimeo = new Vimeo(config('vimeo.CLIENT_IDENTIFIER'), config('vimeo.CLIENT_SECRETS'), config('vimeo.ACCESS_TOKEN'));
//            $id = explode('/', $path['path']);
//            $result = $vimeo->request('/videos/' . $id[2], array(), 'GET');
//            if ($result['status'] == 200) {
//                $video_duration = $result['body']['duration'];
//            }
//        }

            $user_video = $this->checkUserHaveSeenThisBefore($lessonContent);
            $totalPlayed = $user_video ? ( $user_video->totalPlayed > $request->totalPlayed ? $user_video->totalPlayed : $request->totalPlayed) : $request->totalPlayed;
            $videoCompleteWatched = $this->userCompleteWatched($totalPlayed, $video_duration);
            $this->checkUserFinishCourse($lessonContent);
            $userVideo = UserVideo::updateOrCreate(
                ['lesson_content_id'=>$lessonContent->id,
                    'user_id'  =>  $user_id
                ],
                [
                    'lesson_content_id'=>$lessonContent->id,
                    'user_id'          => $user_id,
                    'totalPlayed'      => $totalPlayed,
                    'video_duration'      => $video_duration,
                    'percent'      => $user_video ? ( $user_video->percent > $request->percent * 100 ? $user_video->percent : round($request->percent * 100, 2)) : round($request->percent * 100, 2),
                    'watched'          =>$videoCompleteWatched,
                ]
            );
            return response()->json($userVideo);
        }
        return response()->json();
    }
    public function checkUserHaveSeenThisBefore($lessonContent)
    {
        $user_id = request('user_id') ? request('user_id') : auth()->id();
        return UserVideo::query()->where('lesson_content_id', $lessonContent->id)->where('user_id', $user_id)->first();
    }

    public function userCompleteWatched($totalPlayed, $video_length)
    {
        return    $video_length <= $totalPlayed;
    }

    public function checkUserFinishCourse($lessonContent)
    {
        $course=Course::withCount([
            'orderCourse',
            'lessons',
            'lessonContents'=>fn ($q) =>$q->whereType('video'),
            ])
            ->where('id', $lessonContent->lesson->course_id)
            ->firstOrFail();
        $userFinishedVideosCount=UserVideo::whereWatched(1)
                                    ->whereLessonContentId($lessonContent->id)
                                    ->count();

        if ($course->lesson_contents_count==$userFinishedVideosCount) {
            $user = request('user_id') ? User::query()->where('id', request('user_id'))->first() : auth()->user();
            $userCoursesCount = $user
                              ->orderCourses()
                              ->where('course_id', $course->id)
                              ->first()
                              ->update(['is_watched'=>1]);
        }
    }
}
