<?php

namespace Robinboost\DebugbarDoping\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CalculationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $a;

    public function __construct($a)
    {
        $this->a = $a;
    }

    public function handle()
    {
        Cache::driver('file')->put(md5($this->a), $this->a);
        try {
            Cache::driver('database')->put(md5($this->a), $this->a);
        } catch (\Exception $e) {
        }
    }
}