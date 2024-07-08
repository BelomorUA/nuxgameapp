<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function show($uniqueLink)
    {
        $user = User::where('unique_link', $uniqueLink)->firstOrFail();

        if (!$this::isActive($user)) {
            abort(404, 'Link is expired or deactivated');
        }

        return view('auth/user', compact('user'));
    }

    public function generateNewLink(Request $request, $uniqueLink)
    {
        $user = User::where('unique_link', $uniqueLink)->firstOrFail();

        if (!$this::isActive($user)) {
            abort(404, 'Link is expired or deactivated');
        }

        $newLink = Str::random(32);
        $user->update([
            'unique_link' => $newLink,
            'expires_at' => Carbon::now()->addDays(7),
            'active' => true,
        ]);

        return response()->json(['unique_link' => $newLink]);
    }

    public function deactivateLink(Request $request, $uniqueLink)
    {
        $user = User::where('unique_link', $uniqueLink)->firstOrFail();

        if (!$this::isActive($user)) {
            abort(404, 'Link is expired or deactivated');
        }

        $user->update(['active' => false]);

        return response()->json(['result' => $user]);
    }

    public function feelingLucky(Request $request, $uniqueLink)
    {
        $user = User::where('unique_link', $uniqueLink)->firstOrFail();

        if (!$this::isActive($user)) {
            abort(404, 'Link is expired or deactivated');
        }

        $randomNumber = rand(1, 1000);
        $result = $randomNumber % 2 == 0 ? 'Win' : 'Lose';
        $winAmount = 0;

        if ($result == 'Win') {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        $winAmount = round($winAmount,2);

        Result::create([
            'user_id' => $user->id,
            'random_number' => $randomNumber,
            'result' => $result,
            'win_amount' => $winAmount,
        ]);

        return response()->json(['randomNumber' => $randomNumber, 'result' => $result, 'winAmount' => $winAmount]);
    }

    public function history($uniqueLink)
    {
        $user = User::where('unique_link', $uniqueLink)->firstOrFail();

        if (!$this::isActive($user)) {
            abort(404, 'Link is expired or deactivated');
        }

        $results = Result::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(3)->get(['random_number','result','win_amount']);

        return response()->json(['result' => $results]);
    }

    private function isActive($user){
        if (Carbon::now()->greaterThan($user->expires_at) || !$user->active) {
            return false;
        }
        return true;
    }
}
