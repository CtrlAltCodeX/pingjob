<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Vendor extends Model

{

  protected $guarded = [];





  public function vendorsDetails($employer_id)

  {



    $vendors = DB::table("vendors")

      ->join('users', 'vendors.vendor_id', '=', 'users.id')

      ->join('states', 'users.state_id', '=', 'states.id')

      ->join('countries', 'states.country_id', '=', 'countries.id')

      ->where('vendors.approve_status', 1)

      ->where('vendors.employer_id', $employer_id)

      ->select("vendors.*", 'users.website', 'users.company', 'users.address', 'users.city', 'states.state_name', 'countries.country_name',

        DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews

                                WHERE reviews.employer_id = vendors.vendor_id

                                AND reviews.approve_status = 1) as review_rating"),

        DB::raw("(SELECT COUNT(id) FROM reviews

                                WHERE reviews.employer_id = vendors.vendor_id

                                AND reviews.approve_status = 1) as review_count"),

        DB::raw("(SELECT COUNT(id) FROM vendors as b

                                WHERE b.employer_id = vendors.vendor_id) as vendor_count"))

      ->orderBy('vendor_count', 'desc')->paginate(3);



    return $vendors;

  }





  public function top_client_ids($vendor_id)

  {



    $employer = DB::table("vendors")

      ->join('users', 'vendors.employer_id', '=', 'users.id')

      ->join('states', 'users.state_id', '=', 'states.id')

      ->join('countries', 'states.country_id', '=', 'countries.id')

      ->where('vendors.approve_status', 1)

      ->where('vendors.vendor_id', $vendor_id)

      ->select("vendors.*", 'users.website', 'users.company', 'users.address', 'users.city', 'states.state_name', 'countries.country_name',

        DB::raw("(SELECT (SUM(ratings)/COUNT(id)) FROM reviews

                                WHERE reviews.employer_id = vendors.vendor_id

                                AND reviews.approve_status = 1) as review_rating"),

        DB::raw("(SELECT COUNT(id) FROM reviews

                                WHERE reviews.employer_id = vendors.vendor_id

                                AND reviews.approve_status = 1) as review_count"),

        DB::raw("(SELECT COUNT(id) FROM vendors as b

                                WHERE b.employer_id = vendors.vendor_id) as vendor_count"))

      ->orderBy('vendor_count', 'desc')->paginate(3);



    return $employer;

  }

}

