<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>PingJob | Empowering the job seeker</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5309331350958816"
     crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
      <style type='text/css'>
         thead {
         background:#838485;
         color: white;
         }
         /*		th, td {
         height: 10px !important;
         font-size: 12px;
         width: 90px;
         }*/
         /*		th, td {
         padding: -0.25rem !important;
         }*/
         .nav_btn{
         font-size: 13px;
         color: white !important;
         letter-spacing: 2px;
         border-radius: 40px;
         background: #047a21;
         }
         table {
         font-family: arial, sans-serif;
         border-collapse: collapse;
         width: 100%;
         /*margin-left: 2px;*/
         /*margin-right: 2px;*/
         }
         td, th {
         /*border: 1px solid #dddddd;*/
         /*text-align: center;*/
         font-size: 12px;
         padding: 2px;
         /*border-bottom: 1px solid #dddddd;*/
         }
         /*th {
         font-size: 10px;
         }*/
         tr:nth-child(even) {
         /*background-color: #dddddd;*/
         }
         /*tr{
         margin: 2px;
         }*/
         .card{
         border:0px solid rgba(0,0,0,.125) !important;
         }
         .button {
         background-color: #047a21;
         border: none;
         color: white;
         padding: 4px 12px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 10px;
         margin: 4px 2px;
         cursor: pointer;
         }
         .card-body{
         padding: 0rem !important;
         }
         .card-title {
         margin: .50rem;
         }
         .alpha-bit{
         margin-right: 10px;
         }
         .alpha-bit-href{
         color:black; font-size: 18px;
         }
         .sorting_disabled{
         padding: 2px !important;
         }
         .dataTables_wrapper .dataTables_paginate .paginate_button { padding:0;  }
      </style>
   </head>
   <body style="background-color: #faf9f7;">
      <div class="container-fluid">
         <!-- NAVBAR-->
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
               <a href="https://pingjob.com/" class="navbar-brand">
                  <!-- Logo Image -->
                  <img src="https://pingjob.com/assets/images/logo.png" width="" alt="" class="d-inline-block align-middle mr-2">
                  <!-- Logo Text -->
                  <!-- <span class="text-uppercase font-weight-bold">Company</span> -->
               </a>
               <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
               <div id="navbarSupportedContent" class="collapse navbar-collapse">
                  <ul class="navbar-nav ml-auto">
                     <!-- <li class="nav-item active"><a href="#" class="nav-link">Home <span class="sr-only">(current)</span></a></li> -->
                     <li class="nav-item"><a href="https://pingjob.com/dashboard/employer/job/new" class="nav-link nav_btn mr-2">POST NEW JOB</a></li>
                     <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">LOGIN</a></li>
                     <li class="nav-item"><a href="{{ route('new_register') }}" class="nav-link">REGISTER</a></li>
                  </ul>
               </div>
            </div>
         </nav>
      </div>
      <div class="container-fluid mt-4">
         <div class="row">
            <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="card-title">Search</h4>
                           <form action="jobs" name="myForm"  class="" method="get" id="search_form">
                              <div class="custom-control custom-radio mb-3 m-2">
                                 <style>
                                    input::-webkit-input-placeholder { font-size: 10px; }
                                 </style>
                                 <div class="d-inline-block" style="margin-right: 30px;">
                                    <input class="form-check-input radio_val" type="radio" name="search_category" id="customRadio1" value="job" checked>
                                    <label class="form-check-label" for="customRadio1">JOB</label>
                                 </div>
                                 <div class="d-inline-block">
                                    <input class="form-check-input radio_val" type="radio" name="search_category" id="customRadio2" value="client">
                                    <label class="form-check-label" for="customRadio2">CLIENT</label>
                                 </div>
                              </div>
                              <div class="input-group mb-3">
                                 <input type="text" class="form-control" name="q" placeholder="@lang('app.job_title_placeholder')">
                                 <input type="text" class="form-control" name="location" placeholder="@lang('app.job_location_placeholder')">
                                 <div class="input-group-append">
                                    <button class="btn btn-success" style="background-color:#047a21 !important;" type="submit"> @lang('app.search')</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card mb-3 mt-3" style="border:0px solid rgba(0,0,0,.125); padding:10px 0px 0px 10px;">
                        <div class="card-body">
                           <p class="m-2">
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=@"?>" class="alpha-bit-href">@</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=#"?>" class="alpha-bit-href">#</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=a"?>" class="alpha-bit-href">A</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=b"?>" class="alpha-bit-href">B</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=c"?>" class="alpha-bit-href">C</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=d"?>" class="alpha-bit-href">D</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=e"?>" class="alpha-bit-href">E</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=f"?>" class="alpha-bit-href">F</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=g"?>" class="alpha-bit-href">G</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=h"?>" class="alpha-bit-href">H</a></b><br>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=i"?>" class="alpha-bit-href">I</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=j"?>" class="alpha-bit-href">J</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=k"?>" class="alpha-bit-href">K</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=l"?>" class="alpha-bit-href">L</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=m"?>" class="alpha-bit-href">M</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=n"?>" class="alpha-bit-href">N</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=o"?>" class="alpha-bit-href">O</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=p"?>" class="alpha-bit-href">P</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=q"?>" class="alpha-bit-href">Q</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=r"?>" class="alpha-bit-href">R</a></b><br>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=s"?>" class="alpha-bit-href">S</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=t"?>" class="alpha-bit-href">T</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=u"?>" class="alpha-bit-href">U</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=v"?>" class="alpha-bit-href">V</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=w"?>" class="alpha-bit-href">W</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=x"?>" class="alpha-bit-href">X</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=y"?>" class="alpha-bit-href">Y</a></b>
                              <b class="alpha-bit"><a href="<?php echo "clients_alphabetic?search_category=client&q=z"?>" class="alpha-bit-href">Z</a></b>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">Top Clients</h4>
                           </div>
                           <div class="m-2 float-right">
                              <label>search</label>
                              <input id="topclient" type="text" name="" size="8">
                           </div>
                           <style> 
                              div.dataTables_wrapper div.dataTables_filter{display: none;}
                              .dataTables_wrapper .dataTables_length{
                              display: none;
                              }
                           </style>
                           <div class="table-responsive1">
                              <table id="example1" >
                                 <thead class="text-left">
                                    <tr>
                                       <th>Client</th>
                                       <th>Job(S)</th>
                                       <th>Vendor(S)</th>
                                       <th>Resume(S)</th>
                                    </tr>
                                 </thead>
                                 <tbody id="myclient">
                                    @if($top_clients->isNotEmpty())
                                    @foreach($top_clients as $top_client)
                                    <tr>
                                       <td>{{ $top_client->company }}</td>
                                       <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;"
                                          target="_blank"
                                          href="{{route('jobs_by_employer', $top_client->company_slug)}}">{{ $top_client->job_count }}</a></td>
                                       <td>{{ $top_client->vendor_count }}</td>
                                       <td>{{ $top_client -> applications_count }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card" style="padding: 0px;">
                        <div class="card-body mt-4">
                           <h6><a href="https://pingjob.com/p/about-us" class="text-secondary">About Us</a></h6>
                           <h6><a href="https://pingjob.com/pricing" class="text-secondary">Pricing</a></h6>
                           <h6><a href="https://pingjob.com/p/how-does-it-work" class="text-secondary">How Does It Work?</a></h6>
                           <h6><a href="https://pingjob.com/p/terms-and-conditions" class="text-secondary">Terms And Conditions</a></h6>
                           <h6><a href="https://pingjob.com/p/how-does-it-work-1" class="text-secondary">Privacy Policy</a></h6>
                           <h6><a href="https://pingjob.com/contact-us" class="text-secondary">Contact Us</a></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
            </div>
            <?php //  echo "<pre>";  print_r($categories); ?>
            <div class="col col-sm-12 col-md-6 col-lg-6 col-xl-6">
               <div class="row">
                  @include('admin.flash_msg')
                  @if($premium_jobs->count())
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">Newest job postings</h4>
                           </div>
                           <div class="m-2 float-right">
                              <label>search</label>
                              <input id="post" type="text" name="">
                           </div>
                           <div class="table-responsive1">
                              <table id="example">
                                 <thead>
                                    <tr>
                                       <th>Date</th>
                                       <th>Title</th>
                                       <th>Client</th>
                                       <th>Vendor</th>
                                       <th>Resumes </th>
                                       <th>Location </th>
                                       <th>Action </th>
                                       <th></th>
                                    </tr>
                                 </thead>
                                 <tbody id="mypost">
                                    @foreach($premium_jobs as $job)
                                    <tr>
                                       <td style="width:60px;">{{ date('M-d', strtotime($job->created_at)) }}</td>
                                       <td>
                                          <a class="text-dark" href="{{route('job_view', $job->job_slug)}}">{!! $job->job_title !!}</a>
                                       </td>
                                       <td> <a class="text-dark" href="{{ route('clients_details', ['employer_id' => $job->user_id]) }}">
                                          <b> {!! $job->company !!}</b></a>
                                       </td>
                                       <td>{{$job->vendor_count}}</td>
                                       <td>{!! $job->job_applications_count !!}</td>
                                       <td>@if($job->city_name)
                                          {!! $job->city_name !!},
                                          @endif
                                          @if($job->state_name)
                                          {!! $job->state_name !!}
                                          @endif
                                       </td>
                                       <td><button class="button" data-toggle="modal" data-jobid=' {!! $job->id !!}' data-target="#applyJobModal">Apply</button></td>
                                       <td></td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endif
               </div>
               <!-- row end -->
            </div>
            <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
               <div class="row mt-3">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">States</h4>
                           </div>
                           <div class="table-responsive1">
                              <table id="example3">
                                 <thead >
                                    <tr>
                                       <th>States(S)</th>
                                       <th>Job(S)</th>
                                       <!-- <th>Top Client(S)</th> -->
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php  foreach($total_state_job as $t_states){ ?>
                                    <tr>
                                       <td>{{preg_replace('/[0-9\@\#\.\;]+/', '', $t_states->state_name)}}</td>
                                       <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;" target="_blank" href="{{route('jobs_by_state_or_city',$t_states->state_name)}}">{{$t_states->numberOfSales}}</a></td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <html></html>
                  </div>
               </div>
               <!-- row end -->
               <div class="row mt-3">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">City</h4>
                           </div>
                           <div class="table-responsive1">
                              <table id="example4">
                                 <thead>
                                    <tr>
                                       <th>City</th>
                                       <th>Job(S)</th>
                                       <!-- <th>Top Client(S)</th> -->
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php  foreach($total_city_jobe as $t_city){ ?>
                                    <tr>
                                       <td>{{preg_replace('/[0-9\@\#\.\;]+/', '', $t_city->city_name)}}</td>
                                       <td><a id="jobapplytxt" style="text-decoration:none;color:#165c98;" target="_blank" href="{{route('jobs_by_state_or_city', str_replace(' ', ' ', $t_city->city_name))}}">{{$t_city->numberOfcities}}</a></td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
               <div class="row mt-3">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">Top Vendor</h4>
                           </div>
                           <div class="table-responsive1">
                              <table class="">
                                 <thead class="">
                                    <tr>
                                       <th>Verndors</th>
                                       <th>Total</th>
                                    </tr>
                                 </thead>
                                 <tbody class="">
                                    <?php
                                       foreach($total_vendors_job as $total_vendors){ ?>
                                    <tr>
                                       <td>{{preg_replace('/[0-9\@\#\.\;]+/', '', $total_vendors->name)}}</td>
                                       <td>
                                          <a class="text-info" href="{{ route('topclients_details', ['employer_id' => $total_vendors->id]) }}">
                                          <b> {!! $total_vendors->numberOfclient !!}</b></a>
                                       </td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
               <div class="row mt-3">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="float-left">
                              <h4 class="card-title">Stats</h4>
                           </div>
                           <div class="table-responsive1">
                              <table class="">
                                 <thead class="">
                                    <!-- <tr>
                                       <th>City</th>
                                       <th>Top Client(S)</th>
                                       <th>Job(S)</th>
                                       </tr> -->
                                 </thead>
                                 <tbody class="">
                                    <?php
                                       $clients = config('clients');
                                       $vendors = config('vendors');
                                       $jobs = config('jobs');
                                       $contacts = config('contacts');
                                       $reviews = config('reviews');
                                       $job_applications = config('job_applications');
                                       ?>
                                    <tr>
                                       <td>@lang('app.clients')</td>
                                       <td>({{ $clients->count() }})</td>
                                    </tr>
                                    <tr>
                                       <td>@lang('app.approve_vendor')</td>
                                       <td>({{ $vendors->count() }})</td>
                                    </tr>
                                    <tr>
                                       <td>@lang('app.jobs')</td>
                                       <td>({{ $jobs->count() }})</td>
                                    </tr>
                                    <tr>
                                       <td>@lang('app.approve_contacts')</td>
                                       <td>({{ $contacts->count() }})</td>
                                    </tr>
                                    <tr>
                                       <td>@lang('app.approve_review')</td>
                                       <td>({{ 777 + $reviews->count() }})</td>
                                    </tr>
                                    <tr>
                                       <td>@lang('app.resumes')</td>
                                       <td>({{ 3906 + $job_applications->count() }})</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row end -->
            </div>
         </div>
         <!-- /.row -->
         @if($categories->count())
         <div class="home-categories-wrap pb-5 pt-5 bg-white">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="mb-3">@lang('app.browse_category')</h4>
                  </div>
               </div>
               <div class="row">
                  @foreach($categories as $category)
                  <div class="col-md-3">
                     <p>
                        <a style="font-size:12px;" href="{{route('jobs_listing', ['category' => $category->id])}}"
                           class="text-dark text-decoration-none"><i class="la la-th-large"></i>
                        {{$category->category_name}}
                        <span class="text-muted">({{$category->job_count}})</span> </a>
                     </p>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
         @endif
         <div class="float-right">{!! $categories->links() !!}</div>
      </div>
      <!-- /.container -->
      <!-- Footer -->
      <footer class="page-footer font-small unique-color-dark ml-3 mr-3 mt-5">
         <div class="border">
            <div class="container">
               <!-- Grid row-->
               <div class="row py-2 d-flex align-items-center">
                  <!-- Grid column -->
                  <div class="col-sm-12 col-md-8 col-lg-8 text-center mb-4 mb-md-0">
                     <h6 class="mb-0 text-md-right" >
                        Copyright © <?= date('Y') ?> :
                        <a href="https://pingjob.com/" class="text-dark">
                           PingJob, all rights reserved
                     </h6>
                  </div>
                  <!-- Grid column -->
                  <!-- Grid column -->
                  <div class="col-sm-12 col-md-4 col-lg-4 text-md-right text-lg-right text-sm-center">
                  <!-- Twitter -->
                  <a class="tw-ic" href="https://www.twitter.com/pingjob">
                  <i class="fab fa-twitter white-text mr-4"> </i>
                  </a>
                  <!--Linkedin -->
                  <a class="li-ic" href="https://www.linkedin.com/company/pingjob">
                  <i class="fab fa-linkedin-in white-text mr-4"> </i>
                  </a>
                  <!-- Facebook -->
                  <a class="fb-ic" href="https://www.facebook.com/pingjob">
                  <i class="fab fa-facebook-f white-text mr-4"> </i>
                  </a>
                  <!--Instagram-->
                  <a class="ins-ic" href="https://www.instagram.com/pingjob">
                  <i class="fab fa-instagram white-text"> </i>
                  </a>
                  </div>
                  <!-- Grid column -->
               </div>
               <!-- Grid row-->
            </div>
         </div>
      </footer>
      <!-- Footer -->
      <!-- apply job modala -->
      <div class="modal fade" id="applyJobModal" role="dialog">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <form action="{{route('apply_job')}}" method="post" id="applyJob" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                     <h5 class="modal-title">@lang('app.online_job_application_form')</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     @if(session('error'))
                     <div class="alert alert-warning">{{session('error')}}</div>
                     @endif
                     <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                        <label for="name" class="control-label">@lang('app.name'):</label>
                        <input type="text" class="form-control {{e_form_invalid_class('name', $errors)}}" id="name"
                           name="name" value="@if(Auth::check()) {{ $name = Auth::user()->name}} @else
                           {{old('name') }}
                           @endif" placeholder="@lang('app.your_name')">
                        {!! e_form_error('name', $errors) !!}
                     </div>
                     <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
                        <label for="email" class="control-label">@lang('app.email'):</label>
                        <input type="text" class="form-control {{e_form_invalid_class('email', $errors)}}"
                           id="email" name="email" value="@if(Auth::check()) {{ $email = Auth::user()->email}} @else
                           {{old('email') }}
                           @endif"   placeholder="@lang('app.email_ie')">
                        {!! e_form_error('email', $errors) !!}
                     </div>
                     <div class="form-group {{ $errors->has('phone_number')? 'has-error':'' }}">
                        <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                        <input type="text" class="form-control {{e_form_invalid_class('phone_number', $errors)}}"
                           id="phone_number" name="phone_number" value="@if(Auth::check()) {{ $phone = Auth::user()->phone}} @else
                           {{old('phone_number') }}
                           @endif"
                           placeholder="@lang('app.phone_number')">
                        {!! e_form_error('phone_number', $errors) !!}
                     </div>
                     <div class="form-group {{ $errors->has('message')? 'has-error':'' }}">
                        <label for="message-text" class="control-label">@lang('app.message'):</label>
                        <textarea class="form-control {{e_form_invalid_class('message', $errors)}}" id="message"
                           name="message"
                           placeholder="@lang('app.your_message')">{{old('message')}}</textarea>
                        {!! e_form_error('message', $errors) !!}
                     </div>
                     <div class="form-group {{ $errors->has('resume')? 'has-error':'' }}">
                        <label for="resume" class="control-label">@lang('app.resume'):</label>
                        <input type="file" class="form-control {{e_form_invalid_class('resume', $errors)}}"
                           id="resume" name="resume">
                        <p class="text-muted">@lang('app.resume_file_types')</p>
                        {!! e_form_error('resume', $errors) !!}
                     </div>
                     <input type="hidden" name="job_id" id="job_id" value="">
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                     <button type="submit" class="btn btn-primary" id="report_ad">@lang('app.apply_online')</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- @section('page-js') -->
      <script src="{{ asset('assets/js/main.js') }}"></script>
      <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript">
         $(".radio_val").click(function() {
          let radio_value = $('input[name="search_category"]:checked').val();
          if (radio_value == 'client') {
          document.getElementById('search_form').action = 'clients';
          }else{
          document.getElementById('search_form').action = 'jobs';
          }
         
         })
         
         
         $(document).ready(function(){
           $("#post").on("keyup", function() {
             var value = $(this).val().toLowerCase();
             $("#mypost tr").filter(function() {
               $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
             });
           });
           
             $("#topclient").on("keyup", function() {
             var value = $(this).val().toLowerCase();
             $("#myclient tr").filter(function() {
               $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
             });
           });
         });
         $(document).ready(function () {
          $('#applyJobModal').on('show.bs.modal', function (event) {
               var button = $(event.relatedTarget);
               var job_id = button.data('jobid');
               var modal = $(this);
               modal.find('.modal-body #job_id').val(job_id);
         })
         $('#addContactModal').on('show.bs.modal', function (event) {
               var a = $(event.relatedTarget) 
               var cat_id = a.data('catid') 
               var modal = $(this)
               modal.find('.modal-body #cat_id').val(cat_id);
         })
         });
           $(document).ready(function () {
          $('#applyJobModal').on('show.bs.modal', function (event) {
               var button = $(event.relatedTarget);
               var job_id = button.data('jobid');
               var modal = $(this);
               modal.find('.modal-body #job_id').val(job_id);
         })
         $('#addContactModal').on('show.bs.modal', function (event) {
               var a = $(event.relatedTarget) 
               var cat_id = a.data('catid') 
               var modal = $(this)
               modal.find('.modal-body #cat_id').val(cat_id);
         })
         
         
         
         
         $('#example').dataTable( {
         "ordering": false,
         "pageLength": 20,
         responsive: true
         });
         
         
         $('#example1').dataTable( {
         "ordering": false,
         "pageLength": 15,
         responsive: true
         });
         
         $('#example3').dataTable( {
         "ordering": false,
         "pageLength": 15,
         // responsive: true
         });
         
         $('#example4').dataTable( {
         "ordering": false,
         "pageLength": 15,
         // responsive: true
         });
         
         
         
         });
      </script>
   </body>
</html>