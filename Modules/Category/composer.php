<?php

// Dashboard ViewComposr
view()->composer([
    'category::dashboard.categories.*',
    'category::trainer.categories.*',
    'company::dashboard.companies.*',
    'company::trainer.companies.*',
    'course::dashboard.courses.*',
    'course::trainer.courses.*',
    'course::dashboard.notes.create',
    'course::trainer.notes.create',
    'course::dashboard.notes.edit',
    'course::trainer.notes.edit',
    'apps::frontend.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);
view()->composer([
    'apps::frontend.*',
], \Modules\Category\ViewComposers\Frontend\CategoryComposer::class);
