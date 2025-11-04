<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class LocationController extends Controller
{
    public function provinces()
    {
        return response()->json(
            City::query()->select('province_id','province')->distinct()->orderBy('province')->get()
        );
    }

    public function regenciesByProvince(Request $req)
    {
        $pid = (string)$req->query('province_id', '');
        return response()->json(
            City::where('province_id',$pid)->where('type','KAB')->orderBy('name')->get(['id','name'])
        );
    }

    public function citiesByProvince(Request $req)
    {
        $pid = (string)$req->query('province_id', '');
        return response()->json(
            City::where('province_id',$pid)->where('type','KOTA')->orderBy('name')->get(['id','name'])
        );
    }
}