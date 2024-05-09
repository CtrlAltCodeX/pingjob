<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\FlagJob;
use App\Models\Category;
use App\Helper\Functions;
use App\Mail\ShareByEMail;
use App\Models\ResumesRepo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Carbon;
use App\Mail\AppliedToJobEMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\New_Job_Of_Same_Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function newJob()
    {
        $title = __('app.posIt_new_job');

        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::all();
        $old_country = false;
        if (old('country')) {
            $old_country = Country::find(old('country'));
        }

        $states = State::all();
        $old_state = false;
        if (old('state')) {
            $old_state = State::find(old('state'));
        }

        $cities = City::Where('state_id')->get()->toArray();

        return view('admin.post-new-job', compact('title', 'categories', 'countries', 'old_country', 'old_state', 'states', 'cities'));
    }


    public function newJobPost(Request $request)
    {
        $user_id = Auth::user()->id;

        $country = Country::find($request->country);

        DB::connection('mysql2')->table('wo_job')->insert(
            [
                'title' => request()->job_title,
                'category' => $request->category,
                'description' => $request->description,
            ]
        );

        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'position' => ['required', 'string', 'max:190'],
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'country' => 'required',
            'city' => 'required',
        ];
        
        $this->validate($request, $rules);
        $parsed_date = Carbon::parse($request->deadline);

        $job_title = $request->job_title;
        $job_slug = unique_slug($job_title, 'Job', 'job_slug');
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

        $job_id = strtoupper(Str::random(8));
        $data = [
            'user_id' => $user_id,
            'job_title' => $job_title,
            'job_slug' => $job_slug,
            'position' => $request->position,
            'category_id' => $request->category,
            'is_any_where' => $request->is_any_where,
            'salary' => $request->salary,
            'salary_upto' => $request->salary_upto,
            'is_negotiable' => $request->is_negotiable,
            'salary_currency' => $request->salary_currency,
            'salary_cycle' => $request->salary_cycle,
            'vacancy' => $request->vacancy,
            'gender' => $request->gender,
            'exp_level' => $request->exp_level,
            'job_type' => $request->job_type,
            'experience_required_years' => $request->experience_required_years,
            'experience_plus' => $request->experience_plus,
            'description' => $request->description,
            'skills' => $request->skills,
            'responsibilities' => $request->responsibilities,
            'educational_requirements' => $request->educational_requirements,
            'experience_requirements' => $request->experience_requirements,
            'additional_requirements' => $request->additional_requirements,
            'benefits' => $request->benefits,
            'apply_instruction' => $request->apply_instruction,
            'country_id' => $request->country,
            'country_name' => $country->country_name,
            'state_id' => $request->state,
            'state_name' => $state_name,
            'city_id' => $request->city,
            'city_name' => $city_name,
            'zip_code' => $request->zip_code,
            'deadline' => $parsed_date,
            'status' => 0,
            'is_premium' => $request->is_premium,
        ];

        $user_type = Auth::user()->user_type;

        if ($user_type == 'admin') {
            if (isset($request->client_id)) {
                $user_id = (int)$request->client_id;
                $data['user_id'] = (int)$request->client_id;
                $data['status'] = 0;
            } else {
                $data['user_id'] = $user_id;
                $data['status'] = 0;
            }
        } else {
            $data['user_id'] = $user_id;
            $data['status'] = 0;
        }

        // $this->auto_job_apply($request->category);
        $job = Job::create($data);
        if (!$job) {
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }

        $this->all_users_for_category_id($request->category, $job->id, $user_id, $job_title, $request->position, $request->salary, $request->salary_currency, $request->salary_cycle, $request->experience_required_years, $request->description, $request->skills, $request->responsibilities, $request->educational_requirements, $request->experience_requirements, $request->benefits, $country->country_name, $state_name, $city_name);

        $job->update(['job_id' => $job->id . $job_id]);
        return redirect(route('posted_jobs'))->with('success', __('app.job_posted_success'));
    }


    public function all_users_for_category_id($category_id, $job_id, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name)
    {

        $job_applications = DB::table('job_applications')
            ->select(DB::raw('MAX(id) as id'))->where('category_id', '=', $category_id)
            ->groupBy('email')->get();



        foreach ($job_applications as $job_application) {

            $job_application_of_user = JobApplication::find($job_application->id);

            $user = User::where('email', '=', $job_application_of_user->email)->first();


            $user_id = 0;
            if (isset($user->id)) {
                $user_id = $user->id;
            }


            $application_data = [
                'job_id' => $job_id,
                'employer_id' => $employeer_id,
                'user_id' => $user_id,
                'category_id' => $job_application_of_user->category_id,
                'name' => $job_application_of_user->name,
                'email' => $job_application_of_user->email,
                'phone_number' => $job_application_of_user->phone_number,
                'message' => $job_application_of_user->message,
                'resume' => $job_application_of_user->resume,
                'resume_score' => $job_application_of_user->resume_score,
            ];

            JobApplication::create($application_data);

            Functions::sending_email_to_job_applicant($job_application_of_user->email, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name);
        }
    }

    public function all_users_for_category_id_for_job_edit($category_id, $job_id, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name)
    {

        $job_applications = DB::table('job_applications')
            ->select(DB::raw('MAX(id) as id'))->where('category_id', '=', $category_id)
            ->groupBy('email')->get();



        foreach ($job_applications as $job_application) {

            $job_application_of_user = JobApplication::find($job_application->id);

            $user = User::where('email', '=', $job_application_of_user->email)->first();


            $user_id = 0;
            if (isset($user->id)) {
                $user_id = $user->id;
            }
            // add by ali

            $application_data = [
                'job_id' => $job_id,
                'employer_id' => $employeer_id,
                'user_id' => $user_id,
                'category_id' => $job_application_of_user->category_id,
                'name' => $job_application_of_user->name,
                'email' => $job_application_of_user->email,
                'phone_number' => $job_application_of_user->phone_number,
                'message' => $job_application_of_user->message,
                'resume' => $job_application_of_user->resume,
                'resume_score' => $job_application_of_user->resume_score,
            ];

            JobApplication::create($application_data);

            // add by ali end

            Functions::sending_email_to_job_applicant($job_application_of_user->email, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name);
        }
    }


    public function sending_email_to_job_applicant($email, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name)
    {

        $user = User::find($employeer_id);
        $company_name = $user['company'];


        $request = array('job_title' => $job_title, 'position' => $position, 'salary' => $salary, 'salary_currency' => $salary_currency, 'salary_cycle' => $salary_cycle, 'experience_required_years' => $experience_required_years, 'description' => $description, 'skills' => $skills, 'responsibilities' => $responsibilities, 'educational_requirements' => $educational_requirements, 'experience_requirements' => $experience_requirements, 'benefits' => $benefits, 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name, 'company_name' => $company_name);
        // Mail::to($email)->send(new New_Job_Of_Same_Category($request));commented by ali
        if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Mail::to($email)->send(new New_Job_Of_Same_Category($request));
        } else {
            //Invalid email format
        }
    }



    public function auto_job_apply($category)
    {
        // $created_at = '2021-06-10 00:00:00';
        $current_date = date('Y-m-d H:m:s');
        $ids_arr = [];
        // $request->category
        $category_id = $category;
        $JobApplication_data = JobApplication::where('category_id', $category_id)->whereNotIn('job_id', $ids_arr)->where("created_at", ">", Carbon::now()->subMonths(3))->get();

        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }


        foreach ($JobApplication_data as $key) {
            // echo $key->category_id;
            $created_at = $key->created_at;
            $str_created_at = strtotime($created_at);
            $str_current_date = strtotime($current_date);
            $year1 = date('Y', $str_created_at);
            $year2 = date('Y', $str_current_date);
            $month1 = date('m', $str_created_at);
            $month2 = date('m', $str_current_date);
            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

            array_push($ids_arr, $key->job_id);
            $last_Jobs_data = job::where('category_id', $category_id)->whereNotIn('id', $ids_arr)->where("created_at", ">", Carbon::now()->subMonths(3))->get();

            foreach ($last_Jobs_data as $job) {

                if ($key->category_id == $job->category_id && $key->job_id != $job->id) {
                    $application_data = [
                        'job_id' => $job->id,
                        'employer_id' => $job->user_id,
                        'user_id' => $user_id,
                        'category_id' => $job->category_id,
                        'name' => $key->name,
                        'email' => $key->email,
                        'phone_number' => $key->phone_number,
                        'message' => $key->message,
                        'resume' => $key->resume,
                        'resume_score' => $key->resume_score,
                    ];
                    JobApplication::updateOrCreate($application_data);
                }
            }
        }


        // echo "<pre>";
        // print_r($ids_arr);
        // echo "==========<br>done!";
    }





    public function update(Request $request, $id)
    {

        $user = Auth::user();
        $user_type = $user->user_type;

        $user_id = isset($request->user_id) ? $request->user_id : Auth::user()->id;

        $job = Job::find($id);

        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'position' => ['required', 'string', 'max:190'],
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ];
        $this->validate($request, $rules);

        $job_title = $request->job_title;
        $job_slug = unique_slug($job_title, 'Job', 'job_slug');


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

        $created_at = '';
        if (isset($request->created_at)) {
            $created_at = $request->created_at;
        } else {
            $created_at = $job->created_at;
        }



        $job_id = strtoupper(Str::random(8));
        $data = [
            'user_id' => $user_id,
            'job_title' => $job_title,
            'job_slug' => $job_slug,
            'position' => $request->position,
            'category_id' => $request->category,
            'is_any_where' => $request->is_any_where,
            'salary' => $request->salary,
            'salary_upto' => $request->salary_upto,
            'is_negotiable' => $request->is_negotiable,
            'salary_currency' => $request->salary_currency,
            'salary_cycle' => $request->salary_cycle,
            'vacancy' => $request->vacancy,
            'gender' => $request->gender,
            'exp_level' => $request->exp_level,
            'job_type' => $request->job_type,

            'experience_required_years' => $request->experience_required_years,
            'experience_plus' => $request->experience_plus,
            'description' => $request->description,
            'skills' => $request->skills,
            'responsibilities' => $request->responsibilities,
            'educational_requirements' => $request->educational_requirements,
            'experience_requirements' => $request->experience_requirements,
            'additional_requirements' => $request->additional_requirements,
            'benefits' => $request->benefits,
            'apply_instruction' => $request->apply_instruction,
            'country_id' => $request->country,
            'country_name' => $country->country_name,
            'state_id' => $request->state,
            'state_name' => $state_name,
            'city_id' => $request->city,
            'city_name' => $city_name,
            'zip_code' => $request->zip_code,
            'deadline' => $request->deadline,
            'status' => $job->status,
            'is_premium' => 1,
            'created_at' => $created_at
        ];


        Job::where('id', $id)->update($data);

        if ($request->email_send_to_applicants == 'yes' && $user_type == 'admin') {


            Functions::all_users_for_category_id_for_job_edit($request->category, $id, $user_id, $job_title, $request->position, $request->salary, $request->salary_currency, $request->salary_cycle, $request->experience_required_years, $request->description, $request->skills, $request->responsibilities, $request->educational_requirements, $request->experience_requirements, $request->benefits, $country->country_name, $state_name, $city_name);
        }

        return redirect(route('posted_jobs'))->with('success', __('app.job_posted_update'));
    }




    public function postedJobs()
    {
        $title = __('app.posted_jobs');
        $user = Auth::user();
        $jobs = $user->jobs()->paginate(20);

        return view('admin.jobs', compact('title', 'jobs', 'user'));
    }

    public function edit($id)
    {
        $title = __('app.edit_job');
        $job = Job::find($id);

        $user = User::find(Auth::user()->id);
        if (!$user->is_admin() && $user->id != $job->user_id) {
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }

        $user_id = $job->user_id;

        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::all();
        $old_country = false;
        if ($job->country_id) {
            $old_country = Country::find($job->country_id);
        }



        $states = State::all();
        $old_state = false;
        if ($job->state_id) {
            $old_state = State::find($job->state_id);
        }

        $cities = City::Where('state_id', $job->state_id)->get()->toArray();


        return view('admin.edit-job', compact('title', 'job', 'categories', 'countries', 'old_country', 'old_state', 'states', 'cities', 'user_id', 'user'));
    }

    /**
     * @param null $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * View any single page
     */
    public function view($slug = null)
    {
        $job = Job::whereJobSlug($slug)->first();

        if (!$slug || !$job || (!$job->is_active() && !$job->can_edit())) {
            abort(404);
        }

        $user = new User();
        $company = $user->listOfCompany();

        $employer = $job->employer;
        $vendor_model = new Vendor();
        $vendors = $vendor_model->vendorsDetails($employer?->id);

        $review_ratings = DB::table('reviews')
            ->select(DB::raw('(sum(ratings)/count(id)) AS review_rating, count(id) as review_count'))
            ->where('approve_status', 1)
            ->where('employer_id', $employer?->id)->get();

        $review_count = $review_ratings[0]->review_count;
        $review_ratings = !empty($review_ratings[0]->review_rating) ? $review_ratings[0]->review_rating  : 0;

        $title = $job->job_title;

        return view('frontend.job-view', compact('title', 'job', 'review_ratings', 'review_count', 'company', 'vendors'));
    }


    /**
     * Apply to job
     */
    public function applyJob(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'message' => 'required',
            'resume' => 'required',
        ];

        // dd("fsasd");

        $validator = Validator::make($request->all(), $rules);

        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        // dd($user_id);
        session()->flash('job_validation_fails', true);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        if ($request->hasFile('resume')) {
            $image = $request->file('resume');
            $valid_extensions = ['pdf', 'doc', 'docx'];
            if (!in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions)) {
                session()->flash('job_validation_fails', true);
                return redirect()->back()->withInput($request->input())->with('error', trans('app.resume_file_type_allowed_msg'));
            }

            $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $image_name = strtolower(time() . Str::random(5) . '-' . Functions::str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

            $imageFileName = 'uploads/resume/' . $image_name;
            try {
                //Upload original image
                Storage::disk('public')->put($imageFileName, file_get_contents($image));

                $job = Job::find($request->job_id);

                // get resumes score.
                $category = Category::find($job->category_id);
                $data = Functions::getResumeScore($image_name, [$category->category_name]);
                $score = $data ? $data->score : [0];
                $resume_score = $score[0];
                // get resumes score end.



                //mismatch issue
                // if ($$job->user_id == $user_id) {
                //     $user_id = 0;
                // }
                $application_data = [
                    'job_id' => $request->job_id,
                    'employer_id' => $job->user_id,
                    'user_id' => $user_id,
                    'category_id' => $job->category_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'message' => $request->message,
                    'resume' => $image_name,
                    'resume_score' => $resume_score,
                ];
                JobApplication::create($application_data);
                // send mail here
                $job = Job::find($request->job_id);
                Mail::send(new AppliedToJobEMail($request, $job));
                session()->forget('job_validation_fails');
                return redirect()->back()->withInput($request->input())->with('success', trans('app.job_applied_success_msg'));
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
            }
        }

        return redirect()->back()->withInput($request->input())->with('error', trans('app.error_msg'));
    }

    public function flagJob(Request $request, $id)
    {
        $rules = [
            'reason' => 'required',
            'email' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            session()->flash('flag_job_validation_fails', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $data = [
            'job_id' => $id,
            'reason' => $request->reason,
            'email' => $request->email,
            'message' => $request->message,
        ];
        FlagJob::create($data);

        return redirect()->back()->with('success', __('app.job_flag_submitted'));
    }

    public function pendingJobs()
    {
        $title = __('app.pending_jobs');
        $jobs = Job::pending()->orderBy('updated_at', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }

    public function approvedJobs(\Illuminate\Http\Request $request)
    {
        $title = __('app.approved_jobs');
        $jobs = Job::approved()->orderBy('updated_at', 'desc')->paginate(20);
        return view('admin.approved_jobs', compact('title', 'jobs'));
    }

    public function testt()
    {

        echo '<pre>';
        $start = $_GET['start'];
        $rowperpage = $_GET['length'];
        $response_arr = DB::select(DB::raw("select * from jobs order by id asc limit '$rowperpage' offset '$start' where approved_at = 1"));
        return $response_arr;
    }

    public function approvedJobsAjax(\Illuminate\Http\Request $request)
    {

        $draw = $_GET['draw'];
        $start = $_GET['start'];
        $search = $_GET['search']['value'];
        $rowperpage = $_GET['length'];


        if (!empty($search)) {
            $response_arr = Job::select('*', 'jobs.job_title as job_title', 'jobs.id as id_job')
                ->approved()
                ->orderBy('jobs.updated_at', 'desc')
                ->where('jobs.job_title', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%')
                ->join('users', 'users.id', '=', 'jobs.user_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();


            $total_records_data =  Job::select('*', 'jobs.job_title as job_title', 'jobs.id as id_job')->approved()->orderBy('jobs.updated_at', 'desc')
                ->where('jobs.job_title', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%')
                ->join('users', 'users.id', '=', 'jobs.user_id')
                ->get();
        } else {
            $response_arr = Job::select('*', 'jobs.job_title as job_title', 'jobs.id as id_job')->approved()->orderBy('jobs.updated_at', 'desc')->join('users', 'users.id', '=', 'jobs.user_id')->skip($start)
                ->take($rowperpage)
                ->get();

            $total_records_data =  Job::approved()->orderBy('updated_at', 'desc')->get();
        }


        $total_records = count($total_records_data);
        $displaytotal = $total_records;


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $total_records,
            "iTotalDisplayRecords" => $displaytotal,
            "aaData" => $response_arr,
        );

        return $response;
        // $title = __('app.approved_jobs');
        // $jobs = Job::approved()->orderBy('id', 'desc')->limit(30)->get();


    }

    public function blockedJobs()
    {
        $title = __('app.approved_jobs');
        $jobs = Job::blocked()->orderBy('updated_at', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }

    public function flaggedMessage()
    {
        $title = __('app.flagged_jobs');
        $flagged = FlagJob::orderBy('updated_at', 'desc')->paginate(20);
        return view('admin.flagged_jobs', compact('title', 'flagged'));
    }


    /**
     * @param $job_id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     *
     * Change the job status
     */
    public function statusChange($job_id, $status)
    {
        $job = Job::find($job_id);
        if (!$job->can_edit()) {
            return back()->with('error', __('app.permission_denied'));
        }

        if ($status === 'approve') {

            $job->is_premium = 1;
            $job->status = 1;

            $job->save();
            $job->employer->checkJobBalace();
        } elseif ($status === 'block') {
            $job->status = 2;
            $job->save();
        } elseif ($status === 'delete') {
            $delete = Job::where('id', $job_id)->delete();
        } elseif ($status === 'premium') {
            $balance = $job->employer->premium_jobs_balance;
            if (!$balance) {
                return back()->with('error', "You don't have any premium jobs balance");
            }
            $job->is_premium = 1;
            $job->save();

            $job->employer->checkJobBalace();
        }

        return back()->with('success', __('app.success'));
    }

    public function jobApplicants($job_id)
    {
        $job = Job::find($job_id);

        $title = __('app.applicants') . " For ({$job->job_title})";
        $applications = JobApplication::whereJobId($job_id)->orderBy('updated_at', 'desc')->paginate(20);

        return view('admin.applicants', compact('title', 'applications'));
    }

    public function getDownload($job_id, $pdf_name)
    {
        $url = Storage::disk('public')->path('uploads/resume/' . $pdf_name);
        $urlString = strval($url);
        return Storage::disk('public')->download('uploads/resume/' . $pdf_name);
    }
    public function jobsByEmployer($company_slug = null)
    {
        if (!$company_slug) {
            abort(404);
        }

        $employer = User::select()->where('users.company_slug', 'like', '%' . $company_slug . '%')->first();
        if (!$employer) {
            abort(404);
        }

        $title = "Jobs by " . $employer->company;
        $employer_id = $employer->id;

        $employer_jobs = Job::select()
            ->where('jobs.user_id', 'like', '%' . $employer_id . '%')->orderBy('updated_at', 'desc')->take(125)->paginate(25);

        return view('frontend.jobs-by-employer', compact('title', 'employer', 'employer_jobs'));
    }


    public function ByStateOrcity($company_slug = null)
    {
        if (!$company_slug) {
            abort(404);
        }

        $employer = Job::select()
            ->where('jobs.state_name', 'like', '%' . $company_slug . '%')
            ->orWhere('jobs.city_name', 'like', '%' . $company_slug . '%')->take(75)->paginate(25);
        if (!$employer) {
            abort(404);
        }
        $title = "Jobs by state and city";
        return view('frontend.jobs-by-state_or_city', compact('title', 'employer'));
    }



    public function shareByEmail(Request $request)
    {
        $rules = [
            'receiver_name' => 'required',
            'receiver_email' => 'email|required',
            'your_name' => 'required',
            'your_email' => 'email|required',
            'job_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            session()->flash('share_job_validation_fails', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        try {
            $job = Job::find($request->job_id);
            Mail::send(new ShareByEMail($request, $job));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('app.job_shared_email_msg'));
    }

    public function jobsListing(Request $request)
    {

        $title = "Browse Jobs";

        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::all();
        $old_country = false;
        if (request('country')) {
            $old_country = Country::find(request('country'));
        }

        $jobs = Job::active();



        if ($request->q) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('job_title', 'like', "%{$request->q}%")
                    ->orwhere('position', 'like', "%{$request->q}%")
                    ->orwhere('description', 'like', "%{$request->q}%")->paginate(10);
            });
        }

        if ($request->location) {

            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('city_name', 'like', "%{$request->location}%")
                    ->orWhere('zip_code', 'like', "%{$request->location}%")
                    ->orWhere('state_name', 'like', "%{$request->location}%")->paginate(10);
            });
        }

        if ($request->gender) {
            $jobs = $jobs->whereGender($request->gender);
        }
        if ($request->exp_level) {
            $jobs = $jobs->whereExpLevel($request->exp_level);
        }
        if ($request->job_type) {
            $jobs = $jobs->whereJobType($request->job_type);
        }
        if ($request->country) {
            $jobs = $jobs->whereCountryId($request->country);
        }
        if ($request->state) {
            $jobs = $jobs->whereStateId($request->state);
        }
        if ($request->category) {
            $jobs = $jobs->whereCategoryId($request->category);
        }

        $user = new User();
        $company = $user->listOfCompany();

        $jobs = $jobs->orderBy('updated_at', 'desc')->with('employer')->paginate(10);
        // echo "<pre>"; print_r($jobs); exit();

        return view('frontend.jobs', compact('title', 'jobs', 'categories', 'countries', 'old_country', 'company'));
    }

    function deletedApplicant(Request $request)
    {
        $application = JobApplication::findOrFail($request->id);
        $arr = $application->toArray();
        unset($arr['status']);

        if ($application) {
            // $application_data = (array)$application;
            ResumesRepo::create($arr);
            $application->update(['status' => 0]);
            // $application->delete();
            return back()->with('success', __('app.resume_deleted'));
        }
    }
}
