<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class VideoCollection extends Collection
{
    /**
     * @return \App\Collections\VideoCollection
     */
    public function groupByDate()
    {
        return $this->groupBy(function ($video) {
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
}
