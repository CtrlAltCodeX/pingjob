<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // ping

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'provider_name', 'provider_id', 'password', 'remember_token',
    ];


    public function jobs()
    {
        return $this->hasMany(Job::class)->orderBy('updated_at', 'desc');
    }
    public function is_user()
    {
        return $this->user_type === 'user';
    }
    public function is_admin()
    {
        return $this->user_type === 'admin';
    }
    public function is_employer()
    {
        return $this->user_type === 'employer';
    }
    public function is_agent()
    {
        return $this->user_type === 'agent';
    }

    public function listOfCompany()
    {

        $company = DB::table('users')
            ->select('id', 'company')
            ->whereIn('user_type', ['employer', 'agent'])
            ->orderBy('id', 'desc')->get();

        return $company;
    }

    public function topClients()
    {

        $top_clients = DB::table("users")
            ->whereIn('users.user_type', ['agent', 'employer', 'admin'])
            ->select(
                "users.*",
                DB::raw("(SELECT COUNT(id) FROM vendors
                                WHERE vendors.employer_id = users.id AND approve_status = 1) as vendor_count"),
                DB::raw("(SELECT COUNT(id) FROM contacts
                                WHERE contacts.employer_id = users.id AND approve_status = 1) as contact_count"),
                DB::raw("(SELECT COUNT(id) FROM jobs
                                WHERE jobs.user_id = users.id) as job_count"),
                DB::raw("(SELECT COUNT(id) FROM job_applications
                                WHERE job_applications.employer_id = users.id) as applications_count"),
                DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_rating")
            )
            ->orderBy('job_count', 'desc')->take(30)->get();

        return $top_clients;
    }


    public function searchClients1($arr)
    {

        if ($arr['location'] != '') {
            $search_clients = DB::table("users")
                ->where('users.company', 'like', '%' . $arr['q'] . '%')
                ->where('users.zip_code', '=',  $arr['location'])->orWhere('users.city', '=',  $arr['location'])->orWhere('users.state_name', '=',  $arr['location'])
                ->select(
                    "users.*",
                    DB::raw("(SELECT COUNT(id) FROM vendors
                                WHERE vendors.employer_id = users.id AND approve_status = 1) as vendor_count"),
                    DB::raw("(SELECT COUNT(id) FROM contacts
                                WHERE contacts.employer_id = users.id AND approve_status = 1) as contact_count"),
                    DB::raw("(SELECT COUNT(id) FROM jobs
                                WHERE jobs.user_id = users.id) as job_count"),
                    DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_rating"),
                    DB::raw("(SELECT COUNT(id) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_count")
                )
                ->orderBy('job_count', 'desc')->limit(50)->get();
        } else {
            $search_clients = DB::table("users")
                ->where('users.company', 'like', $arr['q'] . '%')
                ->select(
                    "users.*",
                    DB::raw("(SELECT COUNT(id) FROM vendors
                                WHERE vendors.employer_id = users.id AND approve_status = 1) as vendor_count"),
                    DB::raw("(SELECT COUNT(id) FROM contacts
                                WHERE contacts.employer_id = users.id AND approve_status = 1) as contact_count"),
                    DB::raw("(SELECT COUNT(id) FROM jobs
                                WHERE jobs.user_id = users.id) as job_count"),
                    DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_rating"),
                    DB::raw("(SELECT COUNT(id) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_count")
                )
                ->orderBy('job_count', 'desc')->limit(50)->get();
        }




        return $search_clients;
    }








    public function searchClients($arr)
    {

        if ($arr['location'] != '') {
            $search_clients = DB::table("users")
                ->where('users.company', 'like', '%' . $arr['q'] . '%')
                ->where('users.zip_code', '=',  $arr['location'])->orWhere('users.city', '=',  $arr['location'])->orWhere('users.state_name', '=',  $arr['location'])
                ->select(
                    "users.*",
                    DB::raw("(SELECT COUNT(id) FROM vendors
                                WHERE vendors.employer_id = users.id AND approve_status = 1) as vendor_count"),
                    DB::raw("(SELECT COUNT(id) FROM contacts
                                WHERE contacts.employer_id = users.id AND approve_status = 1) as contact_count"),
                    DB::raw("(SELECT COUNT(id) FROM jobs
                                WHERE jobs.user_id = users.id) as job_count"),
                    DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_rating"),
                    DB::raw("(SELECT COUNT(id) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_count")
                )
                ->orderBy('job_count', 'desc')->limit(50)->get();
        } else {
            $search_clients = DB::table("users")
                ->where('users.company', 'like', '%' . $arr['q'] . '%')
                ->select(
                    "users.*",
                    DB::raw("(SELECT COUNT(id) FROM vendors
                                WHERE vendors.employer_id = users.id AND approve_status = 1) as vendor_count"),
                    DB::raw("(SELECT COUNT(id) FROM contacts
                                WHERE contacts.employer_id = users.id AND approve_status = 1) as contact_count"),
                    DB::raw("(SELECT COUNT(id) FROM jobs
                                WHERE jobs.user_id = users.id) as job_count"),
                    DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_rating"),
                    DB::raw("(SELECT COUNT(id) FROM reviews
                                WHERE reviews.employer_id = users.id
                                AND reviews.approve_status = 1) as review_count")
                )
                ->orderBy('job_count', 'desc')->limit(50)->get();
        }




        return $search_clients;
    }


    public function scopeEmployer($query)
    {
        return $query->whereUserType('employer');
    }
    public function scopeAgent($query)
    {
        return $query->whereUserType('agent');
    }
    public function isEmployerFollowed($employer_id = null)
    {
        if (!$employer_id || !Auth::check()) {
            return false;
        }

        $user = Auth::user();
        $isFollowed = UserFollowingEmployer::whereUserId($user->id)->whereEmployerId($employer_id)->first();

        if ($isFollowed) {
            return true;
        }
        return false;
    }

    public function getFollowersAttribute()
    {
        $followersCount = UserFollowingEmployer::whereEmployerId($this->id)->count();
        if ($followersCount) {
            return number_format($followersCount);
        }
        return 0;
    }

    public function getFollowableAttribute()
    {
        if (!Auth::check()) {
            return true;
        }

        $user = Auth::user();
        return $this->id !== $user->id;
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/uploads/images/logos/' . $this->logo);
        }
        return asset('assets/images/company.png');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getPremiumJobsBalanceAttribute($value)
    {
        return $value;
    }

    public function checkJobBalace()
    {
        $totalPremiumJobsPaid = $this->payments()->success()->sum('premium_job');
        $totalPosted = $this->jobs()->whereIsPremium(1)->count();
        $balance = $totalPremiumJobsPaid - $totalPosted;

        $this->premium_jobs_balance = $balance;
        $this->save();
    }

    public function signed_up_datetime()
    {
        $created_date_time = $this->created_at->timezone(get_option('default_timezone'))->format(get_option('date_format_custom') . ' ' . get_option('time_format_custom'));
        return $created_date_time;
    }
    public function status_context()
    {
        $status = $this->active_status;

        $context = '';
        switch ($status) {
            case '0':
                $context = 'Pending';
                break;
            case '1':
                $context = 'Active';
                break;
            case '2':
                $context = 'Block';
                break;
        }
        return $context;
    }

    public function getResumeUrlAttribute()
    {
        return asset('storage/uploads/resume/' . $this->resume);
    }
    // ping end
}
