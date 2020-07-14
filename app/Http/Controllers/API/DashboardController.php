<?php

namespace App\Http\Controllers\API;

use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $date = Carbon::now();

        if(Gate::allows('isUser')){
            $total_category = Category::count();
            $total_compnay = Company::count();

            $new_companies = Company::latest()->take(5)->get();

            $events = Company::whereMonth('established_at', $date->month)
                ->selectRaw("id, name, TIMESTAMPDIFF(YEAR, DATE(established_at), current_date) AS age")
                ->get();

            return response()->json([
                'total_company' => $total_compnay,
                'total_category' => $total_category,
                'new_companies' => $new_companies,
                'events' => $events,
            ]);
        } else {
            $total_admin = User::where('type', 'admin')->count();
            $total_user = User::where('type', 'user')->count();
            $active_user = User::where('status', 1)->count();
            $inactive_user = User::where('status', 0)->count();
            $total_category = Category::count();
            $total_compnay = Company::count();

            $new_companies = Company::latest()->take(5)->get();

            $events = Company::whereMonth('established_at', $date->month)
                ->selectRaw("id, name, TIMESTAMPDIFF(YEAR, DATE(established_at), current_date) AS age")
                ->get();

            return response()->json([
                'total_admin' => $total_admin,
                'total_user' => $total_user,
                'active_user' => $active_user,
                'inactive_user' => $inactive_user,
                'total_company' => $total_compnay,
                'total_category' => $total_category,
                'new_companies' => $new_companies,
                'events' => $events,
            ]);
        }
    }
}
