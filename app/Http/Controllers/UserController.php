<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Job;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Category;
use App\Helper\Functions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $title = trans('app.users');
        $current_user = Auth::user();
        $users = User::where('id', '!=', $current_user->id)->orderBy('name', 'asc')->paginate(20);
        return view('admin.users', compact('title', 'users'));
    }


    public function show($id = 0)
    {
        if ($id) {
            $title = trans('app.profile');
            $user = User::find($id);

            $is_user_id_view = true;
            return view('admin.profile', compact('title', 'user', 'is_user_id_view'));
        }
    }

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusChange($id, $status = null)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = User::find($id);
        if ($user && $status) {
            if ($status == 'approve') {
                $user->active_status = 1;
                $user->save();
            } elseif ($status == 'block') {
                $user->active_status = 2;
                $user->save();
            }
        }
        return back()->with('success', trans('app.status_updated'));
    }

    public function appliedJobs()
    {
        $title = __('app.applicant');
        $user_id = Auth::user()->id;
        $applications = JobApplication::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20);

        return view('admin.applied_jobs', compact('title', 'applications'));
    }

    public function registerJobSeeker()
    {
        $title = __('app.register_job_seeker');
        return view('frontend.register-job-seeker', compact('title'));
    }

    public function registerJobSeekerPost(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $this->validate($request, $rules);

        $data = $request->input();
        $user_id = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'user_type'     => 'user',
            'password'      => Hash::make($data['password']),
            'active_status' => 1,
        ]);

        $this->assigning_user_id_to_all_job_applications_with_same_email($user_id->id, $data['email']);

        return redirect(route('login'))->with('success', __('app.registration_successful'));
    }

    public function assigning_user_id_to_all_job_applications_with_same_email($user_id, $email)
    {
        if (!empty($user_id) && !empty($email)) {
            $jobs = JobApplication::where('email', $email)->update(['user_id' => $user_id]);
        }
    }

    public function registerEmployer()
    {
        $title = __('app.employer_register');
        $countries = Country::all();
        $old_country = false;
        if (old('country')) {
            $old_country = Country::find(old('country'));
        }
        $cities = City::Where('state_id')->get()->toArray();

        return view('frontend.employer-register', compact('title', 'countries', 'old_country', 'cities'));
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
            'city'     => 'required'
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
            'website'     => $request->website,
            'zip_code'     => $request->zip_code,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city_id' => $request->city,
            'city' => $city_name,
            'active_status' => 0,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful'));
    }


    public function registerAgent()
    {
        $title = __('app.agent_register');
        $countries = Country::all();
        $old_country = false;
        if (old('country')) {
            $old_country = Country::find(old('country'));
        }

        $cities = City::Where('state_id')->get()->toArray();

        return view('frontend.agent-register', compact('title', 'countries', 'old_country', 'cities'));
    }

    public function registerAgentPost(Request $request)
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
            'user_type'     => 'agent',
            'password'      => Hash::make($request->password),

            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'website'     => $request->website,
            'zip_code'     => $request->zip_code,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city_id' => $request->city,
            'city' => $city_name,
            'active_status' => 1,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful'));
    }


    public function employerProfile()
    {
        $title = __('app.employer_profile');
        $user = Auth::user();


        $countries = Country::all();
        $old_country = false;
        if ($user->country_id) {
            $old_country = Country::find($user->country_id);
        }


        $cities = City::Where('state_id', $user->state_id)->get()->toArray();


        return view('admin.employer-profile', compact('title', 'user', 'countries', 'old_country', 'cities'));
    }

    public function employerProfilePost(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'company_size'   => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'state'     => 'required',
        ];

        $this->validate($request, $rules);


        $logo = null;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');

            $valid_extensions = ['jpg', 'jpeg', 'png'];
            if (!in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions)) {
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension');
            }
            $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $resized_thumb = Image::make($image)->resize(256, 256)->stream();

            $logo = strtolower(time() . Str::random(5) . '-' . Functions::str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

            $logoPath = 'uploads/images/logos/' . $logo;

            try {
                Storage::disk('public')->put($logoPath, $resized_thumb->__toString());
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
            }
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





        $data = [
            'company_size'  => $request->company_size,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city_id'          => $request->city,
            'city'    => $city_name,
            'about_company' => $request->about_company,
            'zip_code' => $request->zip_code,
            'website'       => $request->website,
        ];

        if ($logo) {
            $data['logo'] = $logo;
        }

        $user->update($data);

        return back()->with('success', __('app.updated'));
    }


    public function employerApplicant()
    {
        $title = __('app.applicant');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->orderBy('id', 'desc')->paginate(20);

        return view('admin.applicants', compact('title', 'applications'));
    }
    public function employerApplicantResumes()
    {
        $title = __('app.resumes');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->orderBy('id', 'desc')->paginate(10);

        return view('admin.applicants-resumes', compact('title', 'applications'));
    }
    public function employerApplicantResumesByJobId($job_id)
    {
        $job = Job::findOrFail($job_id);

        $title = __('app.resumes') . " For <strong>{$job->job_title}</strong>";
        $applications = JobApplication::whereJobId($job_id)->orderBy('id', 'desc')->paginate(10);

        return view('admin.applicants-resumes-by-job', compact('title', 'applications', 'job_id'));
    }

    public function download_resume($file_name)
    {

        $path = '/uploads/resume/' . $file_name;

        $mimeType = Storage::disk('public')->mimeType($path);
        $file = Storage::disk('public')->get($path);

        // Return a response with the contents of the file
        return new Response($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' .  basename($path) . '"'
        ]);
    }
    public function view_resume($file_name)
    {

        $path = '/uploads/resume/' . $file_name;

        $mimeType = Storage::disk('public')->mimeType($path);
        $file = Storage::disk('public')->get($path);

        // Return a response with the contents of the file
        return new Response($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' .  basename($path) . '"'
        ]);
    }
    public function downloadResumesZip(Request $request)
    {
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->orderBy('id', 'desc')->paginate(10);

        $zipFileName = "applicants-resumes-" . time() . ".zip";
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE);

        foreach ($applications as $file) {
            $path = '/uploads/resume/' . $file->resume;
            $filePath = Storage::disk('public')->path($path);
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"'
        ];
        $file_path = public_path($zipFileName);
        $response = response()->make(file_get_contents($file_path), 200, $headers);

        unlink($file_path);

        return $response;
    }
    public function jobIdDownloadResumesZip(Request $request, $job_id)
    {
        $job = Job::find($job_id);

        // $employer_id = Auth::user()->id;
        $applications = JobApplication::whereJobId($job_id)->orderBy('id', 'desc')->paginate(10);
        $zipFileName = "applicants-resumes-" . time() . ".zip";
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE);

        foreach ($applications as $file) {
            $path = '/uploads/resume/' . $file->resume;
            info($file->resume);
            $filePath = Storage::disk('public')->path($path);
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();
        $file_path = public_path($zipFileName);
        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"'
        ];
        $response = response()->make(file_get_contents($file_path), 200, $headers);

        unlink($file_path);

        return $response;
    }
    public function makeShortList($application_id)
    {
        $applicant = JobApplication::find($application_id);
        $applicant->is_shortlisted = 1;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }

    public function shortlistedApplicant()
    {
        $title = __('app.shortlisted');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->whereIsShortlisted(1)->orderBy('id', 'desc')->paginate(20);

        return view('admin.applicants', compact('title', 'applications'));
    }


    public function profile()
    {
        $title = trans('app.profile');
        $user = Auth::user();

        return view('admin.profile', compact('title', 'user'));
    }

    public function profileEdit($id = '')
    {
        $title = trans('app.profile_edit');
        $user = Auth::user();

        if ($id != '') {
            $user = User::find($id);
        }


        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::all();

        $old_country = false;
        if (old('country')) {
            $old_country = Country::find(old('country'));
        }

        return view('admin.profile_edit', compact('title', 'user', 'countries', 'old_country', 'categories'));
    }

    public function profileEditPost(Request $request, $id = '')
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = Auth::user();
        if ($id != "") {
            $user = User::find($id);
        }
        //Validating
        $rules = [
            'email'    => 'required|email|unique:users,email,' . $user->id,
        ];
        $this->validate($request, $rules);



        if ($request->hasFile('resume')) {
            $image = $request->file('resume');
            $valid_extensions = ['pdf', 'doc', 'docx'];
            if (!in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions)) {
                return redirect()->back()->withInput($request->input())->with('error', trans('app.resume_file_type_allowed_msg'));
            }

            $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $image_name = strtolower(time() . Str::random(5) . '-' . Functions::str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

            $imageFileName = 'uploads/resume/' . $image_name;
            try {
                //Upload original image
                Storage::disk('public')->put($imageFileName, file_get_contents($image));
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
            }
        }

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state) {
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }



        $data = [

            'name' => $request->name,
            'gender' => $request->gender,
            'email' =>  $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'annual_salary' => $request->annual_salary,
            'desired_position' => $request->desired_position,
            'date_available' => date('Y-m-d'),
            'address' => $request->address,
            'address_2' => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,

            'zip_code' => $user->zip_code,
            'hourly_per_rate' => $request->hourly_per_rate,
            'willing_to_relocate' => $request->willing_to_relocate,
            'willing_to_travel' => $request->willing_to_travel,
            'willing_to_telecommute' => $request->willing_to_telecommute,
            'job_classification' => $request->job_classification,
            'skills' => $request->skills,
            'years_of_experience' => $request->years_of_experience,

            'high_degree' => $request->high_degree,
            'last_employer_information' => $request->last_employer_information,
            'job_title' => $request->job_title,
            'job_responsibilities' => $request->job_responsibilities,

            'active_status' => 1,
        ];





        if ($request->hasFile('resume')) {
            $data['resume'] = $image_name;
        }



        $user->update($data);
        return back()->with('success', __('app.updated'));
    }



    public function changePassword()
    {
        $title = trans('app.change_password');
        return view('admin.change_password', compact('title'));
    }

    public function changePasswordPost(Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password'  => 'required',
            'new_password'  => 'required|confirmed',
            'new_password_confirmation'  => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = $request->old_password;
        $new_password = $request->new_password;
        //$new_password_confirmation = $request->new_password_confirmation;

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', trans('app.password_changed_msg'));
            }
            return redirect()->back()->with('error', trans('app.wrong_old_password'));
        }
    }
}
