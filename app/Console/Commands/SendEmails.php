<?php

namespace App\Console\Commands;

use App\Mail\Checkout as SendOrder;
use App\Models\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SendEmails extends Command
{
    private $queue = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled emails based on users timezone';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        $users->each(function($user) {

            $mails = Mail::where('scheduled_at', $user->adoptedTime->format('H:i'))->get();

            if ($mails->isEmpty())
                return true;

            $this->queue[] = $mails->map(function ($mail) use ($user) {
               return (object) ['user_id' => $user->id, 'mail_id' => $mail->id];
            });
        });

        $this->queue = Arr::flatten($this->queue);

//        Not tested
        foreach ($this->queue as $email) {
            \Illuminate\Support\Facades\Mail::raw(Mail::find($email->mail_id)->body, function ($message) use ($email) {
                $message->to(User::find($email->user_id)->email);
            });
        }

    }
}
