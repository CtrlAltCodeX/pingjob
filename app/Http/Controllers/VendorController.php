<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\DB;
  use App\Models\Vendor;

  class VendorController extends Controller
  {
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVendor(Request $request)
    {
      $company = $request->company;
      $employer_id = $request->employer_id;
      $response = [];

      if ($company != '') {

        $companyDetail = DB::table('users')
          ->select('id', 'website', 'name', 'user_type', 'company')
          ->where('company', $company)->first();

        if (!empty($companyDetail)) {

          $vendor = DB::table('vendors')
            ->where('employer_id', $employer_id)
            ->where('vendor_id', $companyDetail->id)
            ->first();

          if (empty($vendor)) {

            $data = [
              'employer_id' => $employer_id,
              'vendor_id' => $companyDetail->id,
              'website' => $companyDetail->website,
              'approve_status' => 0,
            ];
            Vendor::create($data);

            $response = [
              'status' => true,
              'message' => 'Vendor will be added after the approval of administrator'
            ];

          } else {
            if($vendor->approve_status == 0){
              $response = [
                'status' => false,
                'message' => 'Vendor already exist but not approved by Admin'
              ];
            }else{
              $response = [
                'status' => false,
                'message' => 'Vendor already exist'
              ];
            }

          }
        }
      } else {

        $response = [
          'status' => false,
          'message' => 'Invalid company name'
        ];
      }

      return response()->json($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function vendorStatus(Request $request)
    {

      $vendors = DB::table('vendors')
        ->join('users as a', 'vendors.vendor_id', '=', 'a.id')
        ->join('users as b', 'vendors.employer_id', '=', 'b.id')
        ->select('vendors.*', 'a.website', 'a.company', 'b.company as employer')->where('approve_status', '=', 0)
        ->orderBy('vendors.id', 'desc')->paginate(5);

      $title = trans('app.approve_vendor');
      return view('admin.vendor_status', compact('title', 'vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateVendor(Request $request)
    {
      $ids = implode(', ', $request->vendors);
      $approve_status = 0;
      if ($request->status == 1) {
        $approve_status = 1;
      } elseif ($request->status == 2) {
        $approve_status = 2;
      }
      DB::update("update vendors set approve_status = " . $approve_status . " where id IN (" . $ids . ")");

      return back()->with('success', trans('app.vendor_update_success_msg'));
    }

  }
