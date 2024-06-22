<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function getStaticAssets()
    {
        return view('client.assets.fixed_assets.index');
    }
    public function createStaticAssets()
    {
        return view('client.assets.fixed_assets.create');
    }
    public function getDeprec()
    {
        return view('client.depreciations.index');
    }
    public function createDeprec()
    {
        return view('client.depreciations.create');
    }
}
