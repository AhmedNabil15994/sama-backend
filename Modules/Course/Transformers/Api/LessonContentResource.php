<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Entities\UserVideo;

class LessonContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $access = $this->lesson?->course?->current_user_has_access;
        $user_id = \request()->user() ? \request()->user()->id : null;
        $user_video = UserVideo::query()->where('lesson_content_id', $this->id)->where('user_id', $user_id)->first();
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'can_access'        => $access,
            'progress'        => $user_video ? number_format($user_video->percent, 1) : '',
            'is_completed'        => $this->is_completed,
            'video_url'        => $access ? $this->video_link : null,
            'video_url_web_view'        => $access ? route("api.run.video",[$this->id,'lesson']) : null,
        ];
    }
}
