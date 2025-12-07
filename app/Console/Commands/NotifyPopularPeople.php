<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PopularPersonMail;

class NotifyPopularPeople extends Command
{
    protected $signature = 'notify:popular-people';
    protected $description = 'Notify admins when a person reaches 50+ likes';

    public function handle()
    {
        \Log::info("NotifyPopularPeople command started at " . now());

        $this->info('Checking popular people...');

        
        $popularPeople = Like::where('is_like', 1)
            ->selectRaw('person_id, COUNT(*) as likes_count')
            ->groupBy('person_id')
            ->having('likes_count', '>=', 50)
            ->orderByDesc('likes_count')
            ->get();

        if ($popularPeople->isEmpty()) {
            $this->info('No person reached 50 likes yet.');
            return Command::SUCCESS;
        }

        foreach ($popularPeople as $item) {

            $person = Person::find($item->person_id);
            if (!$person) {
                continue; 
            }

            $message = "{$person->name} reached {$item->likes_count} likes!";

            
            Log::info('[Popular Person]', [
                'person_id' => $person->id,
                'likes' => $item->likes_count,
                'name' => $person->name,
            ]);

            
            $this->info($message);

            
            Mail::to('dimaswildan1986@gmail.com')->send(
                new PopularPersonMail($person->id,$person->name, $item->likes_count)
            );
        }

        $this->info('Popular people email notifications sent.');

        return Command::SUCCESS;
    }
}
