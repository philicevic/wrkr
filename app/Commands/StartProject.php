<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Yaml;
use App\Workspace;

class StartProject extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'start:project {name} {category?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Start a new Project in your workspace.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // if category is not set ask for it
        if (!$this->argument('category')) {
            // ask for the wished category
            $this->category = $this->anticipate('Choose a category (empty for default workspace)', Workspace::categories());
        } else {
            $this->category = $this->argument('category');
        }

        $this->task("Creating folder", function () {

            if ($this->category != "") {

                if (in_array($this->category, Workspace::categories())) {

                    // Check if category folder already exists, if not, create it
                    if (!is_dir(getenv('WORKSPACE_PATH') . "/" . $this->category)) {
                        mkdir(getenv('WORKSPACE_PATH') . "/" . $this->category);
                    }

                    // Create project folder
                    mkdir(getenv('WORKSPACE_PATH') . "/" . $this->category . "/" . $this->argument('name'));
                    return true;

                } else {

                    // invalid category -> error
                    $this->error("\nCan't find given category! Following categories are available: " . implode(", ", Workspace::categories()));
                    return false;

                }

            }

            // Create project folder
            mkdir(getenv('WORKSPACE_PATH') . "/" . $this->argument('name'));

            return true;
        });
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
