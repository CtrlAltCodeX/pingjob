<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $data = [
            'usersCount' => User::count(),
            'totalPayments' => Payment::success()->sum('amount'),
            'activeJobs' => Job::active()->count(),
            'totalJobs' => Job::count(),
            'employerCount' => User::employer()->count(),
            'agentCount' => User::agent()->count(),
            'totalApplicants' => JobApplication::count(),

        ];


        return view('admin.dashboard', $data);
    }



    public function help_admin_view_funct(Request $request)
    {

        $help_entries = DB::table('help')
            ->select('*')
            ->orderBy('id', 'desc')->get();

        $title = trans('app.help');
        return view('admin.help', compact('title', 'help_entries'));
    }

    public function help_view_funct(Request $request)
    {

        $title = trans('app.help');
        return view('frontend.help', compact('title'));
    }

    public function help_post_funct(Request $request)
    {

        $data = [
            'subject' => $request->subject,
            'message' => $request->message
        ];

        $help_entries = DB::table('help')->insert($data);

        return redirect()->route('home');
    }
}
