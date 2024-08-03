<?php

namespace Robinboost\DebugbarDoping\Console\Commands;

use Illuminate\Console\Command;

class Test1Health extends Command
{
    protected $signature = 'get-inspired {count=10000} {--all}';

    protected $description = 'Display an inspiring quote for the day';

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
        $this->info('Running for ' . $count . ' times');
        if ($condition) {
            while (true) {
                $a += $i;
                $b = cos(sin(pow(sin(cos(sin(tan($a)))),3)));
                $i++;
            }
        } else {
            for ($i = 0; $i < (int)$count; $i++) {
                $a += $i;
                $b = cos(sin(pow(sin(cos(sin(tan($a)))),3)));
            }
        }
    }
}
