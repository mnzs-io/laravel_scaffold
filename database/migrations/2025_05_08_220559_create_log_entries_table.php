<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    //     public function up(): void
    //     {
    //         $mongo = DB::connection('mongodb')->getMongoDB();
    //         $collectionName = config('app.log.collection', 'log_entries');

    //         // Verifica se a collection já existe
    //         $exists = collect($mongo->listCollections())
    //             ->pluck('name')
    //             ->contains($collectionName);

    //         if (!$exists) {
    //             $mongo->createCollection($collectionName);
    //         }

    //         // Cria índice em 'timestamp'
    //         $mongo->selectCollection($collectionName)
    //             ->createIndex(['timestamp' => -1]);
    //     }

    //     public function down(): void
    //     {
    //         $collectionName = config('app.log.collection', 'log_entries');

    //         DB::connection('mongodb')
    //             ->getMongoDB()
    //             ->dropCollection($collectionName);
    //     }
};
