<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Contacts;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function addContact(Request $request)
    {
        $request->validate([
            'employer_id' => 'required|integer',
            'primary_phone' => 'required|integer|max:11',
            'cell_phone' => 'required|integer|max:11',
            'details' => 'required|string|max:255',
        ]);
        $job = Job::find($request->job_id);

        $contacts = [
            'employer_id' => $request->employer_id, //changed from job_id to employer_id by ali
            'title' => $request->title,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'department' => $request->department,
            'primary_phone' => $request->primary_phone,
            'cell_phone' => $request->cell_phone,
            'email' => $request->email,
            'details' => $request->details,
            'approve_status' => 0,
        ];
        Contacts::create($contacts);

        return back()->with('success', trans('app.contact_submit_msg'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contacts' => 'required'
        ], ['contacts.required' => "please select at least one option"]);
        $ids = '';
        if ($request->contacts) {
            $ids = implode(', ', $request->contacts);
        }
        $approve_status = 0;
        if ($request->status == 1) {
            $approve_status = 1;
        } elseif ($request->status == 2) {
            $approve_status = 2;
        }
        if ($ids) {
            DB::update("update contacts set approve_status = " . $approve_status . " where id IN (" . $ids . ")");
        }

        return back()->with('success', trans('app.contact_update_success_msg'));
    }

    public function contactStatus(Request $request)
    {
        $contacts = DB::table('contacts')
            ->join('users as userA', 'contacts.employer_id', '=', 'userA.id')
            ->select('contacts.*',  'userA.company')->where('approve_status', '=', 0)
            ->orderBy('contacts.id', 'desc')->get();

        $title = trans('app.approve_contacts');
        return view('admin.contacts_status', compact('title', 'contacts'));
    }
}
