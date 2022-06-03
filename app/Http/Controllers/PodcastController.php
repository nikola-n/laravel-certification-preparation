<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPodcast;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    //If you would like to conditionally dispatch a job, you may use
    // the dispatchIf and dispatchUnless methods:
    //
    //ProcessPodcast::dispatchIf($accountActive, $podcast);
    //
    //ProcessPodcast::dispatchUnless($accountSuspended, $podcast);

    public function store(Request $request)
    {
        $podcast = Podcast::create($request->all());

        ProcessPodcast::dispatch($podcast)->afterCommit()
            ->delay(now()->addHours(3));
    }

    public function update(Request $request) {
        Bus::chain([
            new ProcessPodcast,
            new OptimizePodcast,
            new ReleasePodcast,
        ])->dispatch();
    }
}

//SendNotification::dispatchAfterResponse();
//dispatch(function () {
//    Mail::to('taylor@example.com')->send(new WelcomeMessage);
//})->afterResponse();

//php artisan queue:work --tries=3

//Wont queue
//dispatchSync
