<?php

namespace App\Helper;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\New_Job_Of_Same_Category;
use Illuminate\Support\Facades\Storage;

class Functions
{
    public static function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
    public static function str_limit($text, $length = 20, $end = '...')
    {

        return Str::limit($text, $length, $end);
    }
    public static function all_users_for_category_id_for_job_edit($category_id, $job_id, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name)
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
            ];

            JobApplication::create($application_data);

            // add by ali end

            self::sending_email_to_job_applicant($job_application_of_user->email, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name);
        }
    }


    public static function sending_email_to_job_applicant($email, $employeer_id, $job_title, $position, $salary, $salary_currency, $salary_cycle, $experience_required_years, $description, $skills, $responsibilities, $educational_requirements, $experience_requirements, $benefits, $country_name, $state_name, $city_name)
    {

        $user = User::find($employeer_id);
        $company_name = $user['company'];


        $request = array('job_title' => $job_title, 'position' => $position, 'salary' => $salary, 'salary_currency' => $salary_currency, 'salary_cycle' => $salary_cycle, 'experience_required_years' => $experience_required_years, 'description' => $description, 'skills' => $skills, 'responsibilities' => $responsibilities, 'educational_requirements' => $educational_requirements, 'experience_requirements' => $experience_requirements, 'benefits' => $benefits, 'country_name' => $country_name, 'state_name' => $state_name, 'city_name' => $city_name, 'company_name' => $company_name);
        // Mail::to($email)->send(new New_Job_Of_Same_Category($request));commented by ali
        if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($email)->send(new New_Job_Of_Same_Category($request));
        } else {
            //Invalid email format
        }
    }



    public static function auto_job_apply($category)
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
                        'resume' => $key->resume
                    ];
                    JobApplication::updateOrCreate($application_data);
                }
            }
        }


        // echo "<pre>";
        // print_r($ids_arr);
        // echo "==========<br>done!";
    }
    public static function getResumeScore($resumeName, $skillsArray = [])
    {
        $data = (object)['data' => ''];
        // $serverUrl = 'http://127.0.0.1:5000/';
        $serverUrl = 'http://resume-analyzer-env.eba-qsi7it2p.ap-south-1.elasticbeanstalk.com/';
        $urlEndpoint = $serverUrl . 'api/matcher/';
        $path = '/uploads/resume/' . $resumeName;
        $filePath = Storage::disk('public')->path($path);
        if (file_exists($filePath)) {
            $dataFields = array('file' => new \CURLFILE($filePath), 'skill' => json_encode($skillsArray));

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlEndpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $dataFields,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($response);
            if (isset($result->data)) {
                $data = $result->data;
            }
        }
        return $data;
    }
}
