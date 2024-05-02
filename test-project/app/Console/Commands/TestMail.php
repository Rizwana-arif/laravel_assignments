<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Test:Mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This mail is only for testing send to all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Test:Mail command started');
        
        $toEmail = 'rizwanaarif448@gmail.com';
        $subject = 'This mail is for testing purpose only';
        $content = 'This is a test email sent from Laravel developer.';
        
        try {
            \Illuminate\Support\Facades\Mail::raw($content, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)->subject($subject);
            });
    
            Log::info('Test:Mail command completed successfully');
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
        }
    }
    
}
