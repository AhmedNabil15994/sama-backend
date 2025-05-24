<?php

namespace Modules\Course\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Course\Events\SendMailToCourseTrainer;
use Modules\Course\Listeners\NotifyTrainerNewComment;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendMailToCourseTrainer::class => [
            NotifyTrainerNewComment::class,
        ],
    ];
}
