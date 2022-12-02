<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class StatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:statistics {--type=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Items Statistics {--type : Type of statistics all, total, average, highest, monthly}';

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
     * @return int
     */
    public function handle()
    {
        $type = $this->option('type') ?? 'all';
        $statistics = Item::statistics($type);

        if ($type == 'all') {
            $highest = $statistics['highest'];
            unset($statistics['highest']);
            $this->info('Highest provider: ');
            $this->table(array_keys($highest), [$highest]);
            $this->info('Statistics: ');
            $this->table(array_keys($statistics), [$statistics]);
        } else {
            $this->table(array_keys($statistics), $type == 'highest' ? $statistics : [$statistics]);
        }
        return true;
    }
}
