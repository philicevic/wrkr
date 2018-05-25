<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class CreateHtaccess extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:htaccess';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a TYPO3 .htaccess file in current directory';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (file_exists(getcwd() . "/.htaccess")) {
            $this->error("\nERROR: " . getcwd() . "/.htaccess already exists!\n");
            return;
        }
        $htaccess = fopen(getcwd() . "/.htaccess", "w");
        $template = file_get_contents(base_path() . "/storage/typo3.htaccess");
        fwrite($htaccess, $template);
        fclose($htaccess);
        $this->info("Successfully created .htaccess");
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
