<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class playController extends Controller
{
    public function custom()
    {
        return view('custom', [
            'type' => 'custom',
            'user' => auth()->user(),
        ]);
    }

    public function find()
    {
        return view('play', [
            'type' => 'find',
            'user' => auth()->user(),
        ]);
    }

    public function guest()
    {
        return view('play', [
        ]);
    }
}
