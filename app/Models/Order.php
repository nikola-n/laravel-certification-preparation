<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Given the following model, which of the following snippet results in the purchase date being accessible as a Carbon instance?
    public function setPurchaseDateAttribute($value)
    {
        if ( ! $value instanceof Carbon) {
            $value = new Carbon($value);
        }
        $this->attributes['purchase_date'] = $value;
    }

    //$user->purchaseDate = "2020-10-10 10:10:10";
    //$user->setAttribute('purchase_date', "2020-10-10 10:10:10");
    //$user->purchaseDate = new Carbon("2020-10-10 10:10:10");
    //$user->purchase_date = "2020-10-10 10:10:10";
    //skip this question

    //only 3 creates a carbon instance (and then passes it to the model) All others create a string.

    //only 4 is correct.also if option 3 was $user->purchase_date= new Carbon("2020-10-10 10:10:10"); It could be right. remember there is no such purchaseDate attribute in user model. it's just purchase_date. that's right 4 pass strings to attribute but set attribute triggered and convert string to Carbon.

    //Hmm, I question the assessment ability of such a question.
    //
    //A person guessing has 80% chance of getting it right
    //No educated guesser will pick #5
    //That makes it almost a giveaway question

    //Any of the answers should be correct, except for answer 5 ;)

}
