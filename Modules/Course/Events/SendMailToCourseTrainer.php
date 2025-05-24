<?php

namespace Modules\Course\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Course\Entities\ReviewQuestion;

class SendMailToCourseTrainer
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public ReviewQuestion $reviewQuestion)
    {
    }


}
