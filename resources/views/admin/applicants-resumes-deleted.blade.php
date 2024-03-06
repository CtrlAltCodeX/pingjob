@extends('layouts.dashboard')
@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="row" style="border: 1px solid #00000020;">
        @php
            $employer = auth()->user();
        @endphp
        @if ($employer && $employer->premium_jobs_balance)

            <div class="col-md-12">
                @if ($applications->count())
                    {{-- <a href="{{ route('job_id_download_resume_zip', $job_id) . '?page=' . $applications->currentPage() }}"
                        class="btn btn-success m-2">Download listed resumes</a> --}}
                    {{-- <table class="table table-bordered">

                        <tr>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.employer')</th>
                        </tr>



                    </table> --}}
                    <div class="row">
                        <div class="badge-secondary"
                            style="width: 100%; text-align: center; font-size: 18px; font-weight: 600;"><span
                                class="text-danger px-2"><i class="la la-trash-o"></i></span>
                            {{ __('app.resumes') }}</div>
                        @foreach ($applications as $application)
                            <div class="col-12 col-lg-6 d-flex p-1 px-3"
                                style="border: 1px solid rgba(0, 0, 0, 0.125); font-weight: 600;">
                                <div style="width: 40%;"
                                    class="d-flex flex-column align-items-center justify-content-around">
                                    <div style="font-size: 50px;width: fit-content;">
                                        <a href="{{ route('view_resume', $application->resume) }}" target="_blank"
                                            class="text-secondary">
                                            {{-- <a href="{{ route('view_resume', $application->resume) }}" target="_blank"> --}}
                                            <i
                                                class="fas fa-file-{{ getFileTypeByExtension(route('download_resume', $application->resume)) }}"></i>
                                        </a>
                                    </div>
                                    <p class="text-muted"><i class="la la-download"></i> <a
                                            href="{{ route('download_resume', $application->resume) }}"
                                            class="text-secondary">Download Resume </a>
                                    </p>
                                </div>
                                <div style="width: 60%">
                                    <p class="text-muted"><i class="la la-user"></i> {{ $application->name }}</p>
                                    <p class="text-muted"><i class="la la-clock-o"></i>
                                        {{ Carbon\Carbon::parse($application->created_at)->format(get_option('date_format')) }}
                                        {{ Carbon\Carbon::parse($application->created_at)->format(get_option('time_format')) }}
                                    </p>
                                    <p class="text-muted"><i class="la la-envelope-o"></i> {{ $application->email }}</p>
                                    <p class="text-muted mb-0"><i class="la la-phone-square"></i>
                                        {{ $application->phone_number }}</p>
                                    {{-- @php
                                        $currentUser = Auth::user();
                                    @endphp
                                    @if ($currentUser && $currentUser->is_admin())
                                        <form action="{{ route('delete_application') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $application->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm m-1 px-4"><i
                                                    class="la la-trash-o"></i></button>
                                        </form>
                                    @endif --}}
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {!! $applications->links() !!}
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="no data-wrap py-5 my-5 text-center">
                                <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                                <h1>No Data available here</h1>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @else
            <a href="{{ route('pricing') }}" target="_blank">You don't have any jobs balance to add jobs, please
                purchase a package to earn ability of posting jobs</a>

        @endif
    </div>



@endsection
@php
    function getFileTypeByExtension(string $url): string
    {
        $filename = explode('.', $url);
        $extension = end($filename);

        switch ($extension) {
            case 'pdf':
                $type = $extension;
                break;
            case 'docx':
            case 'doc':
                $type = 'word';
                break;
            case 'xls':
            case 'xlsx':
                $type = 'excel';
                break;
            case 'mp3':
            case 'ogg':
            case 'wav':
                $type = 'audio';
                break;
            case 'mp4':
            case 'mov':
                $type = 'video';
                break;
            case 'zip':
            case '7z':
            case 'rar':
                $type = 'archive';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $type = 'image';
                break;
            default:
                $type = 'alt';
        }

        return $type;
    }
@endphp
