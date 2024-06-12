<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\InformMail;
use Illuminate\Contracts\Mail\Mailer;
use \Carbon\Carbon;
use App\Models\Reserve;

class ScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'schedule-command';

    /**
     * Execute the console command.
     */
    public function handle(Mailer $mailer)
    {
        $mailLists=Reserve::with('user','shop')->whereDate('date',Carbon::today())->get();
        foreach($mailLists as $mailList){
            $mailer->to($mailList->user->email)->send(new InformMail($mailList->user->name,$mailList->date,$mailList->time,$mailList->shop->name,$mailList->hc,$mailList->recommendation));
        }

        return 0;
    }
}
