<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\SshConnection;

class SshConnect extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'ssh:connect {host}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Connect to a given host via ssh.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $con = SshConnection::where('host', $this->argument('host'))->get()->first();
        $this->info("ssh ");

        $configuration = new \Ssh\Configuration($con->host);
        $authentication = new \Ssh\Authentication\Password($con->user, $con->password);

        $session = new \Ssh\Session($configuration, $authentication);

        $exec = $session->getExec();

        $run = true;

        while ($run = true) {
            $input = $this->ask("{$con->user}@{$con->host}");
            if ($input === "exit" || $input === "exit;") {
                $run = false;
                $this->info('Exiting ssh.');
                break;
            }
            $output = $exec->run($input);
            $this->line($output);
        }

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
