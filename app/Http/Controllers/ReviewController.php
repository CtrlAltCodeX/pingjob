<?php

  namespace App\Http\Controllers;

  use App\Models\Job;
  use App\Models\User;
  use App\Models\Review;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;


  class ReviewController extends Controller
  {
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {

      $employer = [];

      if (!Auth::check()) {
        session()->flash('error', __('app.login_required_to_review_msg'));
        return redirect()->route('login');
      } else {

        $employer = User::find($request->employer_id);
      }

      return view('frontend.post-review', compact('employer'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectLogin(Request $request){

      $slug = $request->slug;
      $page = $request->page;

      if (!Auth::check()) {
        return redirect()->route('login');
      }

      if($page == 'client_details'){
          return redirect()->route('clients_details', $slug);
      }else if($page == 'job_view'){
         return redirect()->route('job_view', $slug);
      }else{
          return redirect()->route('home');
      }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postReview(Request $request)
    {

      $duplicate = Review::whereEmployerId($request->job_id)->whereUserId($request->employer_id)->count();

      // if ($duplicate > 0){
      //     return back()->with('error', trans('app.category_exists_in_db'));
      // }
      $id = Auth::user()->id;

      $data = [
        'job_id' => $request->job_id,
        'employer_id' => $request->employer_id,
        'user_id' => $id,
        'ratings' => $request->rating_value,
        'comments' => $request->comments,
        'approve_status' => 0,
      ];

      Review::create($data);
      return back()->with('success', trans('app.review_submit_msg'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reviewStatus(Request $request)
    {
      $reviews = DB::table('reviews')
        ->join('users as userA', 'reviews.employer_id', '=', 'userA.id')
        ->join('users as userB', 'reviews.user_id', '=', 'userB.id')
        ->select('reviews.*', 'userB.name', 'userA.company')
        ->orderBy('reviews.id', 'desc')->paginate(5);

      $title = trans('app.approve_review');
      return view('admin.review_status', compact('title', 'reviews'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateReview(Request $request)
    {
      $ids = implode(',', $request->reviews);
      $approve_status = 0;
      if ($request->status == 1) {
        $approve_status = 1;
      } elseif ($request->status == 2) {
        $approve_status = 2;
      }
      DB::update("update reviews set approve_status = " . $approve_status . " where id IN (" . $ids . ")");

      return back()->with('success', trans('app.review_update_success_msg'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function userReviewStatus(Request $request)
    {

      $user_id = Auth::user()->id;

      $reviews = DB::table('reviews')
        ->join('users', 'reviews.employer_id', '=', 'users.id')
        ->select('reviews.*', 'users.company')
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')->paginate(1);

      $title = trans('app.approve_review');
      return view('admin.user_review_status', compact('title', 'reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function userReviews(Request $request)
    {
      $employer = $review_comments = [];
      $job_id = $request->job_id;
      $job = Job::find($job_id);

      if (!empty($request->employer_id) && !empty($request->job_id)) {

        $reviews = Review::whereEmployerId($request->employer_id)->get();
        $employer = User::find($request->employer_id);

        $company = DB::table('users')
          ->select('id', 'company')
          ->whereIn('user_type', ['employer', 'agent'])
          ->orderBy('id', 'desc')->get();

        if ($reviews->isNotEmpty()) {
          $review_comments = DB::table('reviews')
            ->join('users as b', 'reviews.user_id', '=', 'b.id')
            ->select('reviews.*', 'b.name')
            ->where('approve_status', 1)
            ->where('employer_id', $request->employer_id)
            ->orderBy('created_at', 'desc')
            ->get();
        }
      }


      $review_ratings = DB::table('reviews')
        ->select(DB::raw('(sum(ratings)/count(id)) AS review_rating, count(id) as review_count'))
        ->where('employer_id', $employer->id)
        ->where('approve_status', 1)->get();

      $review_ratings = !empty($review_ratings[0]->review_rating) ? $review_ratings[0]->review_rating : 0;

      return view('frontend.review-details', compact('employer', 'review_comments', 'job', 'review_ratings', 'company'));
    }

  }
