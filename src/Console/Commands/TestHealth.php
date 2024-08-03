<?php

namespace Robinboost\DebugbarDoping\Console\Commands;

use Illuminate\Console\Command;
use Robinboost\DebugbarDoping\Jobs\CalculationsJob;
use Robinboost\DebugbarDoping\Jobs\CalculationsMemJob;

class TestHealth extends Command
{
    protected $signature = 'motivate {count=10} {--all} {--queue=1}';

    protected $description = 'Display an inspiring quote';

    public function handle()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);

        $a = 0;
        $i = 0;
        $count = $this->argument('count');
        $all = $this->option('all', false);
        $condition = false;
        if($all) {
            $condition = true;
        }

        $this->info('Inf: ' . ($condition ? 'true' : 'false'));

        if ($condition) {
            while (true) {
                $a += $i;
                $this->doThis($a, $i);
                $i++;
            }
        } else {
            for ($i = 0; $i < (int)$count; $i++) {
                $a += $i;
                $this->info('Iteration: ' . $i);
                $this->doThis($a, $i);
            }
        }
    }

    public function doThis($a, $i)
    {
        if ($i % 2 == 0) {
            if($this->option('queue')) {
                CalculationsJob::dispatch($a);
            } else {
                CalculationsJob::dispatchSync($a);
            }
        } else {
            if($this->option('queue')) {
                CalculationsMemJob::dispatch($a);
            } else {
                CalculationsMemJob::dispatchSync($a);
            }
        }
    }
}
