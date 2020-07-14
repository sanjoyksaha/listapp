<?php

namespace App\Http\Controllers\API;

use App\Company;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {   
        $date = Carbon::now();

        $b = Company::whereMonth('established_at', $date->month)
            ->selectRaw("id, name, established_at, TIMESTAMPDIFF(YEAR, DATE(established_at), current_date) AS age")
            ->get();

        return response($b, Response::HTTP_ACCEPTED);
    }
}
