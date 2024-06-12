<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon\Carbon;
use App\Models\Review;
use App\Models\Reserve;

class ReviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'review-schedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subHour=Carbon::now()->subHour(1)->format('h:i:s');
        $guests=Reserve::whereDate('date',Carbon::today())->whereTime('time','>=',$subHour)->get();
        foreach($guests as $guest){
            $review=Review::where('user_id',$guest->user_id)->where('shop_id',$guest->shop_id)->first();
            if(empty($review)){
                Review::create(['user_id'=>$guest->user_id,'shop_id'=>$guest->shop_id]);
            }
        }
        return 0;
    }
}
