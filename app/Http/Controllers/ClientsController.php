<?php

namespace App\Http\Controllers;


use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Vendor;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{

    public function clientsListing(Request $request)
    {

        $users = new User();

        $arr = [
            'q' => $request->q,
            'location' => $request->location
        ];


        $search_clients = $users->searchClients($arr);



        return view('frontend.clients', compact('search_clients'));
    }


    public function clientsListingApproval(Request $request)
    {

        $clients = DB::table('users')
            ->select('*')->where('active_status', '=', 0)
            ->where('user_type', '=', 'employer')
            ->orderBy('users.id', 'desc')->paginate(5);

        $title = trans('app.approve_client');
        return view('admin.client_status', compact('title', 'clients'));
    }


    public function clientsUpdateApproval(Request $request)
    {

        $ids = implode(',', $request->clients);
        $approve_status = 0;
        if ($request->status == 1) {
            $approve_status = 1;
        } elseif ($request->status == 2) {
            $approve_status = 2;
        }
        DB::update("update users set active_status = " . $approve_status . " where id IN (" . $ids . ")");

        return back()->with('success', trans('app.client_update_success_msg'));
    }


    public function employerList()
    {
        $clients = DB::table('users')
            ->select('*')->where('active_status', '=', 1)
            ->where('user_type', '=', 'employer')
            ->orderBy('users.id', 'desc')->paginate(20);

        $title = trans('app.approve_client');
        return view('admin.client_list', compact('title', 'clients'));
    }

    public function employerListSearchByName()
    {

        $name = $_GET['search'];
        $clients = DB::table('users')
            ->select('id', 'company as label')->where('active_status', '=', 1)
            ->where('user_type', '=', 'employer')
            ->where('name', 'LIKE', "%$name%")
            ->orderBy('users.id', 'desc')->limit(50)->get();

        return $clients;
    }



    public function clientsListing1(Request $request)
    {

        $users = new User();

        $arr = [
            'q' => $request->q,
            'location' => $request->location
        ];


        $search_clients = $users->searchClients1($arr);



        return view('frontend.clients1', compact('search_clients'));
    }




    public function clientsDetails(Request $request, $id)
    {

        $vendor_model = new Vendor();
        $vendors = $vendor_model->vendorsDetails($id);

        $employer = User::findOrFail($id);


        $review_ratings = DB::table('reviews')
            ->select(DB::raw('(sum(ratings)/count(id)) AS review_rating, count(id) as review_count'))
            ->where('approve_status', 1)
            ->where('employer_id', $id)->get();

        $review_count = $review_ratings[0]->review_count;
        $review_ratings = !empty($review_ratings[0]->review_rating) ? $review_ratings[0]->review_rating  : 0;


        $contacts = DB::table('contacts')
            ->where('approve_status', 1)
            ->where('employer_id', $id)->get();



        $user = new User();
        $company = $user->listOfCompany();

        return view('frontend.client-details', compact('review_ratings', 'review_count', 'vendors', 'employer', 'contacts', 'company'));
    }




    public function topclientsDetails(Request $request, $id)
    {

        $vendor_model = new Vendor();
        $vendors = $vendor_model->top_client_ids($id);

        $employer = User::find($id);


        $review_ratings = DB::table('reviews')
            ->select(DB::raw('(sum(ratings)/count(id)) AS review_rating, count(id) as review_count'))
            ->where('approve_status', 1)
            ->where('employer_id', $id)->get();

        $review_count = $review_ratings[0]->review_count;
        $review_ratings = !empty($review_ratings[0]->review_rating) ? $review_ratings[0]->review_rating  : 0;


        $contacts = DB::table('contacts')
            ->where('approve_status', 1)
            ->where('employer_id', $id)->get();



        $user = new User();
        $company = $user->listOfCompany();

        return view('frontend.client-details', compact('review_ratings', 'review_count', 'vendors', 'employer', 'contacts', 'company'));
    }


    public function client_change_status($client_id, $status)
    {

        if ($status == 'block') {
            User::where('id', $client_id)->update(['active_status' => 0]);
            return redirect(route('employeer_list'))->with('success', __('app.client_blocked'));
        }
        if ($status == 'delete') {
            User::where('id', $client_id)->delete();
            return redirect(route('employeer_list'))->with('success', __('app.client_deleted'));
        }

        return redirect(route('employeer_list'));
    }

    public function client_edit($client_id)
    {

        $employer = User::find($client_id);
        $title = __('app.employer_register');
        $states = State::Where('country_id')->get()->toArray();
        $cities = City::Where('state_id')->get()->toArray();

        $countries = Country::all();
        $old_country = false;
        if ($employer->country_id) {
            $old_country = Country::find($employer->country_id);
        }

        $states = State::all();
        $old_state = false;
        if ($employer->state_id) {
            $old_state = State::find($employer->state_id);
        }

        $cities = City::Where('state_id', $employer->state_id)->get()->toArray();

        return view('admin.client_edit', compact('title', 'countries', 'old_country', 'states', 'cities', 'employer', 'client_id'));
    }

    public function client_edit_post(Request $request)
    {


        $rules = [
            'name'      => ['required', 'string', 'max:190'],
            'company'   => 'required',
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
            'phone'     => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'state'     => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state) {
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }

        $city_name = null;
        if ($request->city) {
            $city = City::find($request->city);
            $city_name = $city->name;
        }

        $company_slug = unique_slug($request->company, 'User', 'company_slug');

        $data = [
            'name'          => $request->name,
            'company'       => $request->company,
            'company_slug'  => $company_slug,
            'email'         => $request->email,
            'user_type'     => 'employer',
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city_id' => $request->city,
            'city' => $city_name,
            'zip_code'      => $request->zip_code,
            'website'       => $request->website
        ];

        User::where('id', $request->client_id)->update($data);

        return redirect(route('employeer_list'))->with('success', __('app.employeer_posted_update'));
    }

    public function client_add_view()
    {
        $title = __('app.employer_register');
        $countries = Country::all();
        $old_country = false;
        if (old('country')) {
            $old_country = Country::find(old('country'));
        }
        $cities = City::Where('state_id')->get()->toArray();

        return view('admin.client_add', compact('title', 'countries', 'old_country', 'cities'));
    }

    public function registerEmployerPost(Request $request)
    {
        $rules = [
            'name'      => ['required', 'string', 'max:190'],
            'company'   => 'required',
            'email'     => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
            'phone'     => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'state'     => 'required',
        ];
        $this->validate($request, $rules);

        $company = $request->company;
        $company_slug = unique_slug($company, 'User', 'company_slug');

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state) {
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }

        $city_name = null;
        if ($request->city) {
            $city = City::find($request->city);
            $city_name = $city->name;
        }

        User::create([
            'name'          => $request->name,
            'company'       => $company,
            'company_slug'  => $company_slug,
            'email'         => $request->email,
            'user_type'     => 'employer',
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city_id'       => $request->city,
            'zip_code'      => $request->zip_code,
            'website'       => $request->website,
            'city'          => $city_name,
            'active_status' => 1,
        ]);

        return redirect(route('client_add_view'))->with('success', __('app.registration_successful'));
    }
}
