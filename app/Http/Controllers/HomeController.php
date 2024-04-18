<?php



namespace App\Http\Controllers;



use App\Models\Category;

use App\Models\Job;

use App\Models\JobApplication;

use App\Mail\ContactUs;

use App\Mail\ContactUsSendToSender;

use App\Models\Post;

use App\Models\Pricing;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;



class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        //$this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()
    {
        $categories = Category::orderBy('job_count', 'desc')
            ->where('job_count', '>=', 1)->get();

        $top_city = DB::table('jobs')
            ->join('users as userA', 'jobs.user_id', '=', 'userA.id')
            ->select('jobs.city_name', (DB::raw('COUNT(jobs.user_id) AS total_job')))
            ->groupBy('jobs.city_name')
            ->having(DB::raw('COUNT(jobs.city_name)'), '>', 1)->orderBy('jobs.id', 'desc')
            ->take(15)
            ->get();

        $city_details = [];

        foreach ($top_city as $key) {
            $city_client = DB::table('jobs')
                ->join('users as userA', 'jobs.user_id', '=', 'userA.id')
                ->select((DB::raw('COUNT(jobs.user_id) AS total_client')))
                ->groupBy('jobs.id')
                ->where('jobs.city_name', $key->city_name)
                ->orderBy('jobs.id', 'desc')->take(15)
                ->get();
            array_push($city_details, (object)array($key->city_name, $key->total_job, $city_client[0]->total_client));
        }

        $total_city_jobe = DB::select("SELECT jobs.city_id,jobs.city_name,  COUNT(*) AS numberOfcities FROM jobs JOIN cities ON cities.id = jobs.city_id GROUP BY jobs.city_id,jobs.city_name ORDER BY COUNT(*) DESC limit 15");

        $premium_jobs = DB::table("jobs")
            ->join('users as userA', 'jobs.user_id', '=', 'userA.id')
            ->where('status', 1)
            ->where('is_premium', 1)
            ->select(
                "jobs.*",
                'userA.company',
                'userA.logo',
                DB::raw("(SELECT COUNT(id) FROM job_applications
                            WHERE job_applications.job_id = jobs.id) as job_applications_count"),
                DB::raw("(SELECT COUNT(id) FROM vendors
                            WHERE vendors.employer_id = userA.id AND approve_status = 1) as vendor_count")
            )
            ->orderBy('updated_at', 'desc')
            // ->take(20)
            ->paginate(20);

        $total_state_job = DB::select("SELECT jobs.state_id,jobs.state_name,  COUNT(*) AS numberOfSales FROM jobs JOIN states ON states.id = jobs.state_id GROUP BY jobs.state_id,jobs.state_name ORDER BY COUNT(*) DESC limit 15");

        $total_vendors_job = DB::select("SELECT users.id,users.name,  COUNT(*) AS numberOfclient FROM users
            JOIN vendors ON vendors.vendor_id =  users.id
            GROUP BY users.id, users.name ORDER BY COUNT(*) DESC LIMIT 30");
        $users = new User();

        $top_clients = $users->topClients();
        $blog_posts = Post::whereType('post')
            ->with('author')->orderBy('id', 'desc')
            ->take(3)
            ->get();

        // return count($total_state_job);
        $packages = Pricing::all();

        return view('frontend.home', compact('categories', 'premium_jobs', 'packages', 'blog_posts', 'top_clients', 'total_city_jobe', 'total_state_job', 'total_vendors_job'));
    }

    public function test()
    {
        $categories = Category::orderBy('job_count', 'desc')->where('job_count', '>=', 1)->limit(40);

        $top_city = DB::table('jobs')->join('users as userA', 'jobs.user_id', '=', 'userA.id')

            ->select('jobs.city_name', (DB::raw('COUNT(jobs.user_id) AS total_job')))

            ->groupBy('jobs.city_name')

            ->having(DB::raw('COUNT(jobs.city_name)'), '>', 1)->orderBy('jobs.id', 'desc')->take(15)

            ->get();

        // 3933

        $city_details = [];

        foreach ($top_city as $key) {

            $city_client = DB::table('jobs')->join('users as userA', 'jobs.user_id', '=', 'userA.id')

                ->select((DB::raw('COUNT(jobs.user_id) AS total_client')))

                ->groupBy('jobs.id')

                ->where('jobs.city_name', $key->city_name)->orderBy('jobs.id', 'desc')->take(15)

                ->get();

            array_push($city_details, (object)array($key->city_name, $key->total_job, $city_client[0]->total_client));
        }



        $total_city_jobe = DB::select("SELECT jobs.city_id,jobs.city_name,  COUNT(*) AS numberOfcities FROM jobs JOIN cities ON cities.id = jobs.city_id GROUP BY jobs.city_id,jobs.city_name ORDER BY COUNT(*) DESC LIMIT 25");







        $premium_jobs = DB::table("jobs")->join('users as userA', 'jobs.user_id', '=', 'userA.id')

            ->where('status', 1)

            ->where('is_premium', 1)

            ->select(
                "jobs.*",
                'userA.company',

                DB::raw("(SELECT COUNT(id) FROM job_applications

                                WHERE job_applications.job_id = jobs.id) as job_applications_count"),

                DB::raw("(SELECT COUNT(id) FROM vendors

                                WHERE vendors.employer_id = userA.id AND approve_status = 1) as vendor_count")
            )

            ->orderBy('created_at', 'desc')->take(100)->get();







        $total_state_job = DB::select("SELECT jobs.state_id,jobs.state_name,  COUNT(*) AS numberOfSales FROM jobs JOIN states ON states.id = jobs.state_id GROUP BY jobs.state_id,jobs.state_name ORDER BY COUNT(*) DESC LIMIT 25");





        $total_vendors_job = DB::select("SELECT users.id,users.name,  COUNT(*) AS numberOfclient FROM users

          JOIN vendors ON vendors.vendor_id =  users.id

          GROUP BY users.id, users.name ORDER BY COUNT(*) DESC LIMIT 15");



        // dd($total_vendors_job);



        $users = new User();

        $top_clients = $users->topClients();



        $blog_posts = Post::whereType('post')->with('author')->orderBy('id', 'desc')->take(3)->get();



        $packages = Pricing::all();



        return view('frontend.testHome', compact('categories', 'premium_jobs', 'packages', 'blog_posts', 'top_clients', 'total_city_jobe', 'total_state_job', 'total_vendors_job'));



        //   return view('home', compact('categories', 'premium_jobs', 'packages', 'blog_posts', 'top_clients'));



    }



    public function newRegister()

    {

        $title = __('app.register');
        return view('frontend.new_register', compact('title'));
    }



    public function pricing()
    {
        $title = __('app.pricing');

        $packages = Pricing::all();
        return view('frontend.pricing', compact('title', 'packages'));
    }



    public function contactUs()

    {

        $title = trans('app.contact_us');

        return view('frontend.contact_us', compact('title'));
    }



    public function contactUsPost(Request $request)

    {

        $rules = [
            'name' => 'required|regex:/^\s*([a-zA-Z]+(?:\s[a-zA-Z]+)*)\s*$/',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'nullable|string',
        ];



        $this->validate($request, $rules, ["name" => "Please enter a valid name"]);



        try {

            Mail::send(new ContactUs($request));

            Mail::send(new ContactUsSendToSender($request));
        } catch (\Exception $exception) {

            return redirect()->back()->with('error', '<h4>' . trans('app.smtp_error_message') . '</h4>' . $exception->getMessage());
        }



        return redirect()->back()->with('success', trans('app.message_has_been_sent'));
    }



    /**

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

     *

     * Clear all cache

     */

    public function clearCache()

    {

        Artisan::call('optimize:clear');

        Artisan::call('view:clear');

        Artisan::call('route:clear');

        Artisan::call('config:clear');

        Artisan::call('cache:clear');

        if (function_exists('exec')) {

            exec('rm ' . storage_path('logs/*'));
        }

        return redirect(route('home'));
    }





    public function send_mail()

    {



        ini_set("SMTP", "mail.gmail.com");

        ini_set("smtp_port", "25");



        $headers =  'MIME-Version: 1.0' . "\r\n";

        $headers .= 'From: Your name <hm.younas22@gmail.com>' . "\r\n";

        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



        mail('phpfiverrpk@gmail.com', 'subject', 'hello', $headers);
    }
}
