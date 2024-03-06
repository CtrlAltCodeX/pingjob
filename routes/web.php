<?php

use App\Models\Category;
use App\Helper\Functions;
use App\Models\ResumesRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ResumesRepoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/send_a_test_mail', function () {
//     $request = array(
//         'job_title' => "Test job", 'position' => "test position",
//         'salary' => "999", 'salary_currency' => "666", 'salary_cycle' => "hourly",
//         'experience_required_years' => "3", 'description' => "test description",
//         'skills' => "no skill required", 'responsibilities' => "stay free",
//         'educational_requirements' => "matric pass", 'experience_requirements' => "no specific",
//         'benefits' => "stay free all the time", 'country_name' => "gajomata", 'state_name' => "pindipatian",
//         'city_name' => "test city", 'company_name' => "company test"
//     );
//     Mail::to("alihussain7516@gmail.com")->send(new New_Job_Of_Same_Category($request));
//     return 'done';
// });

Route::get('create_score', function () {
    // return Category::all();
    return "disabled";
    $applications = ResumesRepo::select("resumes_repos.*", "categories.category_name")
        ->join('categories', "resumes_repos.category_id", "=", "categories.id")
        ->orderBy('resumes_repos.id', 'desc')
        ->where('resumes_repos.resume_score', null)
        ->orWhere('resumes_repos.resume_score', '')
        ->orWhere('resumes_repos.resume_score', '0')
        ->get();
    // dd($applications);
    foreach ($applications as $application) {
        $data = Functions::getResumeScore($application->resume, [$application->category_name]);
        $score = isset($data->score) && $data->score != "" ? $data->score : [0];
        $application->resume_score = $score[0];
        $application->save();
        // echo $application->resume . ":" . $application->category_name . "-".($score[0]) . "<br>";
    }
    // exit;
    return redirect()->route('view_resumes_repo');
    // echo "done";
})->middleware('auth');

Route::get('create_a_migation', function () {
    // $exitCode = \Artisan::call('migrate', [
    //     '--path' => 'database/migrations/2023_06_18_150426_add_resume_score_to_resumes_repos.php',
    // ]);
    // $exitCode = \Artisan::call('migrate', [
    //     '--path' => 'database/migrations/2023_06_18_155804_add_resume_score_to_job_applications.php',
    // ]);
    // echo $exitCode;
    echo "migrate";
});
Route::get('clear_all', function () {
    $exitCode = \Artisan::call('optimize:clear');
    echo "Cleared";
});

Auth::routes();

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.add');
Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.add');

Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect']);
Route::get('/callback/{provider}', [SocialController::class, 'callback']);


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/test', [HomeController::class, 'test'])->name('testHome');

Route::get('/contact', [EmailController::class, 'index']);


Route::get('clear', [HomeController::class, 'clearCache'])->name('clear_cache');

Route::get('new-register', [HomeController::class, 'newRegister'])->name('new_register');
Route::get('job-seeker-register', [UserController::class, 'registerJobSeeker'])->name('register_job_seeker');
Route::post('job-seeker-register', [UserController::class, 'registerJobSeekerPost']);

Route::get('employer-register', [UserController::class, 'registerEmployer'])->name('register_employer');
Route::post('employer-register', [UserController::class, 'registerEmployerPost']);

Route::get('agent-register', [UserController::class, 'registerAgent'])->name('register_agent');
Route::post('agent-register', [UserController::class, 'registerAgentPost']);

Route::post('get-states-options', [LocationController::class, 'getStatesOption'])->name('get_state_option_by_country');

Route::post('get-city-options', [LocationController::class, 'getCityOption'])->name('get_city_option_by_state');



Route::get('apply_job', function () {
    return redirect(route('home'));
});
Route::post('apply_job', [JobController::class, 'applyJob'])->name('apply_job');
Route::post('delete_application', [JobController::class, 'deletedApplicant'])->name('delete_application');
Route::post('add_contact', [ContactsController::class, 'addContact'])->name('add_contact');
Route::post('flag-job/{id}', [JobController::class, 'flagJob'])->name('flag_job_post');
Route::post('share-by-email', [JobController::class, 'shareByEmail'])->name('share_by_email');
Route::get('employer/{user_name}/jobs', [JobController::class, 'jobsByEmployer'])->name('jobs_by_employer');
Route::get('ByStateOrcity/{user_name}/jobs', [JobController::class, 'ByStateOrcity'])->name('jobs_by_state_or_city');
Route::post('follow-unfollow', [FollowerController::class, 'followUnfollow'])->name('follow_unfollow');

Route::get('jobs/', [JobController::class, 'jobsListing'])->name('jobs_listing');
Route::get('clients/', [ClientsController::class, 'clientsListing'])->name('clients_listing');
Route::get('clients_alphabetic/', [ClientsController::class, 'clientsListing1'])->name('clients_listing1');

Route::get('dashboard/clients/', [ClientsController::class, 'clientsListingApproval'])->name("dashboard_approve_client");
Route::post('dashboard/clients/', [ClientsController::class, 'clientsUpdateApproval'])->name("dashboard_client_update");


//help
Route::group(['prefix' => 'help'], function () {
    Route::get('/admin', [DashboardController::class, 'help_admin_view_funct'])->name('help_admin_view');

    Route::get('/', [DashboardController::class, 'help_view_funct'])->name('help_view');
    Route::post('/', [DashboardController::class, 'help_post_funct'])->name('help_post');
});

Route::get('clients/{id}', [ClientsController::class, 'clientsDetails'])->name('clients_details');
Route::get('top-clients/{id}', [ClientsController::class, 'topclientsDetails'])->name('topclients_details');

Route::get('reviews/', [ReviewController::class, 'index'])->name('reviews')->middleware('auth');
Route::get('redirect-login/', [ReviewController::class, 'redirectLogin'])->name('redirect-login')->middleware('auth');
Route::get('user-reviews/', [ReviewController::class, 'userReviews'])->name('user_reviews');
Route::post('review-post/', [ReviewController::class, 'postReview'])->name('post_review');
Route::post('add-vendor/', [VendorController::class, 'addVendor'])->name('add_vendor');


Route::get('p/{slug}', [PostController::class, 'showPage'])->name('single_page');

Route::get('blog', [PostController::class, 'blogIndex'])->name('blog_index');
Route::get('blog/{slug}', [PostController::class, 'view'])->name('blog_post_single');

Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');

Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact_us');
Route::post('contact-us', [HomeController::class, 'contactUsPost']);

Route::get('all_users_for_category_id', [JobController::class, 'all_users_for_category_id'])->name('all_users_for_category_id');

//checkout
Route::get('checkout/{package_id}', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('checkout-payment/{package_id}', [PaymentController::class, 'checkoutPost'])->name('checkout.payment');

Route::get('payment/{transaction_id}', [PaymentController::class, 'payment'])->name('payment');
Route::post('payment/{transaction_id}', [PaymentController::class, 'paymentPost']);

Route::any('payment/{transaction_id}/success', [PaymentController::class, 'paymentSuccess'])->name('payment_success');
Route::any('payment-cancel', [PaymentController::class, 'paymentCancelled'])->name('payment_cancel');

//PayPal
Route::post('payment/{transaction_id}/paypal', [PaymentController::class, 'paypalRedirect'])->name('payment_paypal_pay');
Route::any('payment/paypal-notify/{transaction_id?}', [PaymentController::class, 'paypalNotify'])->name('paypal_notify');


Route::post('payment/{transaction_id}/stripe', [PaymentController::class, 'paymentStripeReceive'])->name('payment_stripe_receive');

Route::post('payment/{transaction_id}/bank-transfer', [PaymentController::class, 'paymentBankTransferReceive'])->name('bank_transfer_submit');


//Dashboard Route
Route::group(['prefix' => 'dashboard', 'middleware' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');


    Route::get('applied-jobs', [DashboardController::class, 'dashboard'])->name('applied_jobs');
    Route::get('user-review-status', [ReviewController::class, 'userReviewStatus'])->name('user_review_status');

    Route::get('resumes-repo', [ResumesRepoController::class, 'index'])->name('view_resumes_repo');
    Route::get('resumes-repo/add', [ResumesRepoController::class, 'addResume'])->name('add_to_resumes_repo');
    Route::post('resumes-repo/store', [ResumesRepoController::class, 'storeResume'])->name('store_to_resumes_repo');
    Route::get('resumes-repo/download/zip', [ResumesRepoController::class, 'downloadZip'])->name('download_repo_resumes_zip');


    Route::group(['middleware' => 'admin_agent_employer'], function () {

        Route::group(['prefix' => 'employer'], function () {

            Route::group(['prefix' => 'job'], function () {
                Route::get('new', [JobController::class, 'newJob'])->name('post_new_job');
                Route::post('new', [JobController::class, 'newJobPost']);
                Route::get('edit/{job_id}', [JobController::class, 'edit'])->name('edit_job');
                Route::post('edit/{job_id}', [JobController::class, 'update']);
                Route::get('posted', [JobController::class, 'postedJobs'])->name('posted_jobs');
            });

            Route::get('applicant', [UserController::class, 'employerApplicant'])->name('employer_applicant');
            Route::get('download_resume/{file_name}', [UserController::class, 'download_resume'])->name('download_resume');
            Route::get('shortlisted', [UserController::class, 'shortlistedApplicant'])->name('shortlisted_applicant');
            Route::get('applicant/{application_id}/shortlist', [UserController::class, 'makeShortList'])->name('make_short_list');
            Route::get('applicant/resumes', [UserController::class, 'employerApplicantResumes'])->name('employer_applicant_resumes');
            Route::get('applicant/resumes/{job_id}', [UserController::class, 'employerApplicantResumesByJobId'])->name('employer_applicant_resumes_by_job_id');
            Route::get('download_resume/view/{file_name}', [UserController::class, 'view_resume'])->name('view_resume');
            Route::get('resume/download/zip', [UserController::class, 'downloadResumesZip'])->name('download_resume_zip');
            Route::get('job/{job_id}/resume/download/zip', [UserController::class, 'jobIdDownloadResumesZip'])->name('job_id_download_resume_zip');

            Route::get('profile', [UserController::class, 'employerProfile'])->name('employer_profile');
            Route::post('profile', [UserController::class, 'employerProfilePost'])->name('employer_profile_update');

            Route::get('list', [ClientsController::class, 'employerList'])->name('employeer_list');
            Route::get('search-client-by-name', [ClientsController::class, 'employerListSearchByName'])->name('search-client-by-name');

            Route::get('client_status/{id}/{status}', [ClientsController::class, 'client_change_status'])->name('client_status_change');
            Route::get('client_edit/{client_id}', [ClientsController::class, 'client_edit'])->name('client_edit');
            Route::post('client_edit', [ClientsController::class, 'client_edit_post'])->name('client_edit_post');

            Route::get('add', [ClientsController::class, 'client_add_view'])->name('client_add_view');
            Route::post('add', [ClientsController::class, 'registerEmployerPost'])->name('client_register');
        });
        Route::group(['prefix' => 'jobs'], function () {
            Route::get('/', [JobController::class, 'pendingJobs'])->name('pending_jobs');
            Route::get('pending', [JobController::class, 'approvedJobs'])->name('approved_jobs');
            Route::get('approvedjobsajax', [JobController::class, 'approvedJobsAjax'])->name('approvedJobsAjax');

            Route::get('blocked', [JobController::class, 'blockedJobs'])->name('blocked_jobs');
            Route::get('status/{id}/{status}', [JobController::class, 'statusChange'])->name('job_status_change');

            Route::get('applicants/{job_id}', [JobController::class, 'jobApplicants'])->name('job_applicants');
            Route::get('applicants/{job_id}/getDownload/{pdf_name}', [JobController::class, 'getDownload'])->name('getDownload');
        });



        Route::get('flagged', [JobController::class, 'flaggedMessage'])->name('flagged_jobs');
        Route::get('add-employer', [DashboardController::class, 'Add_new_employer'])->name('add-employer');

        Route::group(['prefix' => 'cms'], function () {
            Route::get('/', [PostController::class, 'index'])->name('pages');
            Route::get('page/add', [PostController::class, 'addPage'])->name('add_page');
            Route::post('page/add', [PostController::class, 'store']);

            Route::get('page/edit/{id}', [PostController::class, 'pageEdit'])->name('page_edit');
            Route::post('page/edit/{id}', [PostController::class, 'pageEditPost']);

            Route::get('posts', [PostController::class, 'indexPost'])->name('posts');
            Route::get('post/add',  [PostController::class, 'addPost'])->name('add_post');
            Route::post('post/add', [PostController::class, 'storePost']);

            Route::get('post/edit/{id}', [PostController::class, 'postEdit'])->name('post_edit');
            Route::post('post/edit/{id}', [PostController::class, 'postUpdate']);
        });
    });


    Route::group(['middleware' => 'only_admin_access'], function () {
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', [ContactsController::class, 'contactStatus'])->name('dashboard_contacts');
            Route::post('/update/', [ContactsController::class, 'updateContact'])->name('dashboard_contacts_update');
        });
    });



    Route::group(['middleware' => 'only_admin_access'], function () {
        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/', [ReviewController::class, 'reviewStatus'])->name('dashboard_reviews');
            Route::post('/update/', [ReviewController::class, 'updateReview'])->name('dashboard_reviews_update');
        });






        Route::group(['prefix' => 'vendors'], function () {
            Route::get('/', [VendorController::class, 'vendorStatus'])->name('dashboard_vendors');
            Route::post('/update/', [VendorController::class, 'updateVendor'])->name('dashboard_vendors_update');
        });



        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('dashboard_categories');
            Route::post('/', [CategoriesController::class, 'store']);

            Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('edit_categories');
            Route::post('edit/{id}', [CategoriesController::class, 'update']);

            Route::post('delete-categories', [CategoriesController::class, 'destroy'])->name('delete_categories');
        });

        //Settings
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingsController::class, 'GeneralSettings'])->name('general_settings');

            Route::get('theme-settings', [SettingsController::class, 'ThemeSettings'])->name('theme_settings');
            Route::get('gateways', [SettingsController::class, 'GatewaySettings'])->name('gateways_settings');
            Route::get('pricing', [SettingsController::class, 'PricingSettings'])->name('pricing_settings');
            Route::post('pricing', [SettingsController::class, 'PricingSave']);

            //Save settings / options
            Route::post('save-settings', [SettingsController::class, 'update'])->name('save_settings');
        });
    });


    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments');

        Route::get('view/{id}', [PaymentController::class, 'view'])->name('payment_view');
        Route::get('status-change/{id}/{status}', [PaymentController::class, 'markSuccess'])->name('status_change');
    });

    Route::group(['prefix' => 'u'], function () {
        Route::get('applied-jobs',  [UserController::class, 'appliedJobs'])->name('applied_jobs');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::get('profile/edit', [UserController::class, 'profileEdit'])->name('profile_edit');
        Route::post('profile/edit', [UserController::class, 'profileEditPost'])->name('profile_edit_post');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('view/{slug}', [UserController::class, 'show'])->name('users_view');
            Route::get('user_status/{id}/{status}', [UserController::class, 'statusChange'])->name('user_status');

            //Edit
            Route::get('edit/{id}', [UserController::class, 'profileEdit'])->name('users_edit');
            Route::post('edit/{id}', [UserController::class, 'profileEditPost']);
            Route::get('profile/change-avatar/{id}', [UserController::class, 'changeAvatar'])->name('change_avatar');
        });

        /**
         * Change Password route
         */
        Route::group(['prefix' => 'account'], function () {
            Route::get('change-password', [UserController::class, 'changePassword'])->name('change_password');
            Route::post('change-password', [UserController::class, 'changePasswordPost']);
        });
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::post('change-password', [UserController::class, 'changePasswordPost']);
    });
});


//Single Sigment View
Route::get('{slug}', [JobController::class, 'view'])->name('job_view');
