@extends('layouts.theme')

@push('css')
<style>
    .package {
        box-shadow: 0px 0px 5px #ccc;
        background-color: white;
        border: none;
        border-radius: 10px !important;
    }

    .pricing-table-wrap {
        box-shadow: 0px 0px 5px #ccc;
        padding: 2.5rem;
        border-radius: 1rem
    }

    .package-container {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-top: 2.5rem;
        margin-bottom: 2.5rem;
        grid-gap: 30px;
    }

    .free-package {
        background-color: #38c172 !important;
        color: white;
    }
</style>
@endpush

@section('content')

<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 5px solid #FFF;
        border-bottom-color: #FF3D00;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="pricing-section bg-white pb-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pricing-section-heading mb-5 text-center">
                    <h1>Pricing</h1>
                    <h5 class="text-muted">Choose a package to unlock Job Posting ability.</h5>
                    <h5 class="text-muted">To get a large amount of quality application, choose the premium package</h5>
                </div>

            </div>
        </div>

        <div class="row package-container">

            @foreach($packages as $key => $package)
            @if($key == 1 )
            <div style="margin-top: -20px;">
                @else
                <div>
                    @endif
                    <div class="pricing-table-wrap bg-light pt-5 pb-5 text-center @if($key == 0) free-package @endif">
                        <h1 class="display-4">{!! get_amount($package->price) !!}</h1>
                        <h3>{{$package->package_name}}</h3>

                        @if($key == 0)
                        <div class="pricing-package-ribbon pricing-package-ribbon-green">
                            Job Seeker
                        </div>
                        <div style="display: grid;grid-gap:5px;">
                            <!-- <p class="mb-2 text-muted">{{$package->premium_job}} Jobs Post</p> -->
                            <p class="mb-2">Lifetime Access</p>
                            <p class="mb-2">Manage Multiple Resumes</p>
                            <p class="mb-2">Single User</p>
                            <p class="mb-2">Dashboard for applied Jobs</p>
                            <p class="mb-2">Social Google/Facebook Login</p>
                            <p class="mb-2">Daily email</p>
                            <p class="mb-2">Social App for direct client interaction</p>
                            <p class="mb-2">Automatic Assignment to Jobs</p>
                            <a class="btn btn-success mt-4 package" style="color: #38c172;" data-toggle="modal" data-target="#myModal{{$key}}" id="{{$package->id}}">
                                <i class="la la-shopping-cart"></i> Sign for free</a>
                        </div>
                        @endif

                        @if($key == 1)
                        <div class="pricing-package-ribbon pricing-package-ribbon-green">
                            Employer
                        </div>

                        <div style="display: grid;grid-gap:15px;">
                            <p class="mb-2 text-muted">Access Resumes with Score</p>
                            <p class="mb-2 text-muted">10 Jobs Post</p>
                            <p class="mb-2 text-muted">Instant Display of Candidates with score (NLP feature)</p>
                            <p class="mb-2 text-muted">Dashboard Management</p>
                            <p class="mb-2 text-muted">Social Google/Facebook Login</p>
                            <p class="mb-2 text-muted">Social App for direct interaction</p>
                            <p class="mb-2 text-muted">No subscription, cancel anytime</p>
                            <a class="btn btn-success mt-4 package" data-toggle="modal" data-target="#myModal{{$key}}" id="{{$package->id}}">
                                <i class="la la-shopping-cart"></i> Go Pro</a>
                        </div>
                        @endif

                        @if($key == 2)
                        <div class="pricing-package-ribbon pricing-package-ribbon-green">
                            Employer
                        </div>
                        <div style="display: grid;">
                            <p class="mb-2 text-muted">Unlimited Access Resumes with Score</p>
                            <p class="mb-2 text-muted">Unlimited Jobs Post</p>
                            <p class="mb-2 text-muted">Single User</p>
                            <p class="mb-2 text-muted">Instant Display of Candidates with score (NLP feature)</p>
                            <p class="mb-2 text-muted">Dashboard Management</p>
                            <p class="mb-2 text-muted">Social Google/Facebook Login</p>
                            <p class="mb-2 text-muted">Social App for direct interaction</p>
                            <p class="mb-2 text-muted">E-Mail support.</p>
                            <p class="mb-2 text-muted">No subscription, cancel anytime</p>
                            <a class="btn btn-success mt-4 package" data-toggle="modal" data-target="#myModal{{$key}}" id="{{$package->id}}">
                                <i class="la la-shopping-cart"></i> Go to Business</a>
                        </div>
                        @endif
                    </div>

                    <div id="myModal{{$key}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body" id="body{{$package->id}}">
                                    <div id="loader{{$package->id}}" class="text-center"></div>
                                </div>
                                <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    @endsection

    @push('js')
    <script>
        $(document).ready(function() {
            $(".package").click(function() {
                var id = $(this).attr("id");
                $.ajax({
                    type: 'GET',
                    url: "/checkout/" + id,
                    beforeSend: function() {
                        $("#loader" + id).html('<div class="loader" ></div>');
                    },
                    success: function(data) {
                        $("#body" + id).html(data);
                    }
                });
            })
        })
    </script>
    @endpush