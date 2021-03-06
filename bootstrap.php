<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Extend;
use Flarum\Forum\Controller\FrontendController;
use Flarum\Subscriptions\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

return [
    (new Extend\Assets('forum'))
        ->asset(__DIR__.'/js/forum/dist/extension.js')
        ->asset(__DIR__.'/less/forum/extension.less')
        ->bootstrapper('flarum/subscriptions/main'),
    (new Extend\Routes('forum'))
        ->get('/following', 'following', FrontendController::class),
    function (Dispatcher $events, Factory $views) {
        $events->subscribe(Listener\AddDiscussionSubscriptionAttribute::class);
        $events->subscribe(Listener\FilterDiscussionListBySubscription::class);
        $events->subscribe(Listener\SaveSubscriptionToDatabase::class);
        $events->subscribe(Listener\SendNotificationWhenReplyIsPosted::class);
        $events->subscribe(Listener\FollowAfterReply::class);

        $views->addNamespace('flarum-subscriptions', __DIR__.'/views');
    }
];
