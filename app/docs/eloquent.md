# Eloquent Collections

- reject method:
  used to remove models from a collection based on the results of an invoked closure.

$flights = Flight::where('destination', 'Paris')->get();

$flights = $flights->reject(function ($flight) { return $flight->cancelled; });

# Chunking results

- useful for large data
- chunk method:

The chunk method will retrieve a subset of Eloquent models, passing them to a closure for processing. Chunk method will
provide significantly reduced memory usage when working with a large number of models

Flight::chunk(200, function ($flights) { foreach ($flights as $flight) { // } });

The first argument passed to the chunk method is the number of records you wish to receive per "chunk". The closure
passed as the second argument will be invoked for each chunk that is retrieved from the database.

- chunkById method:

If you are filtering the results of the chunk method based on a column that you will 
also be updating while iterating over the results, you should use the chunkById method. 
chunkById method will always retrieve models with an id column greater than the last model 
in the previous chunk:

Flight::where('departed', true)
->chunkById(200, function ($flights) {
$flights->each->update(['departed' => false]);
}, $column = 'id');

# Streaming Results Lazily
The lazy method works similarly to the chunk method in the sense that, behind the scenes,
it executes the query in chunks.

returns a flattened LazyCollection of Eloquent models, which lets you interact with
the results as a single stream:

use App\Models\Flight;

foreach (Flight::lazy() as $flight) {
//
}
