<?php

namespace App\Models;

use App\Collections\VideoCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * @return mixed
     */
    public static function recentByDate()
    {
        return self::latest()->get()->groupBy(function ($video) {
            if ($video->created_at->isToday()) {
                return 'Today';
            }

            if ($video->created_at->isCurrentWeek()) {
                return 'this week';
            }

            if ($video->created_at->isCurrentWeek()) {
                return 'last week';
            }

            return 'older';
        });
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return \App\Collections\VideoCollection
     */
    public function newCollection(array $models = [])
    {
            return new VideoCollection($models);
    }
}
