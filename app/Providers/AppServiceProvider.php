<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\Post;
use App\Models\User;
use App\Models\Option;
use App\Models\Review;
use App\Models\Vendor;
use App\Models\Contacts;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paginator::useBootstrap();
        Paginator::useBootstrapFive();
        try {
            DB::connection()->getPdo();

            $options = Option::all()->pluck('option_value', 'option_key')->toArray();
            $allOptions = [];
            $allOptions['options'] = $options;
            $allOptions['header_menu_pages'] = Post::whereStatus('1')->where('show_in_header_menu', 1)->get();
            $allOptions['footer_menu_pages'] = Post::whereStatus('1')->where('show_in_footer_menu', 1)->get();
            $allOptions['clients'] = User::where('user_type', '!=', 'user')->where('active_status', 1)->get();
            $allOptions['vendors'] = Vendor::where('approve_status', 1)->get();
            $allOptions['jobs'] = Job::where('status', 1)->get();
            $allOptions['contacts'] = Contacts::where('approve_status', 1)->get();
            $allOptions['reviews'] = Review::where('approve_status', 1)->get();
            $allOptions['job_applications'] = JobApplication::where('resume', '!=', 'NULL')->get();
            config($allOptions);

            /**
             * Set dynamic configuration for third party services
             */
            $facebookConfig = [
                'services.facebook' =>
                    [
                        'client_id' => get_option('fb_app_id'),
                        'client_secret' => get_option('fb_app_secret'),
                        'redirect' => url('callback/facebook'),
                    ]
            ];
            $googleConfig = [
                'services.google' =>
                    [
                        'client_id' => get_option('google_client_id'),
                        'client_secret' => get_option('google_client_secret'),
                       'redirect' => url('callback/google'),
                    ]
            ];
            $twitterConfig = [
                'services.twitter' =>
                    [
                        'client_id' => get_option('twitter_consumer_key'),
                        'client_secret' => get_option('twitter_consumer_secret'),
                        'redirect' => url('login/twitter-callback'),
                    ]
            ];
            config($facebookConfig);
            config($googleConfig);
            config($twitterConfig);

        }catch (\Exception $e){
            //echo $e->getMessage();
        }
    }
}
