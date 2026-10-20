<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:make-admin {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to administrator role';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = (string) $this->argument('username');

        $user = User::query()->where('username', $username)->first();

        if (!$user) {
            $this->error("User with username '{$username}' not found.");
            return Command::FAILURE;
        }

        $user->role = 'admin';
        $user->save();

        $this->info("User '{$username}' has been promoted to 'admin' role successfully.");
        return Command::SUCCESS;
    }
}
