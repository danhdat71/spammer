<?php

namespace Database\Seeders;

use App\Models\SpamMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CreateSpamMesssageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $messages = [
            [
                'message' => 'Message 1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'message' => 'Message 2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'message' => 'Message 3',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        SpamMessage::insert($messages);
    }
}
