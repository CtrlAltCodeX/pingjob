<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Job;
use App\Models\Category;
use App\Helper\Functions;
use App\Models\ResumesRepo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ResumesRepoController extends Controller
{
    public function index()
    {
        $title = __('app.all_resumes');
        $applications = ResumesRepo::select("resumes_repos.*", "categories.category_name")
            ->join('categories', "resumes_repos.category_id", "=", "categories.id")
            ->orderBy('resumes_repos.resume_score', 'desc')
            ->paginate(10);
            
        return view('admin.applicants-resumes-repo', compact('title', 'applications'));
    }
    public function addResume()
    {
        $title = __('app.add_resume');
        $categories = Category::all(['id', 'category_name AS name']);
        return view('admin.add_resume_in_repo', compact('title', 'categories'));
    }
    public function storeResume(Request $request)
    {
        $rules = [
            'name' => 'required',
            'category_id' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'message' => 'required',
            'resume' => 'required',
        ];
        $ruleMessages = [
            'category_id.required' => "Category is required"
        ];



        $validator = Validator::make(array_map('trim', $request->all()), $rules, $ruleMessages);

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        // dd($user_id);
        session()->flash('job_validation_fails', true);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        if ($request->hasFile('resume')) {
            $image = $request->file('resume');
            $valid_extensions = ['pdf', 'doc', 'docx'];
            if (!in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions)) {
                // session()->flash('job_validation_fails', true);
                return redirect()->back()->withInput($request->input())->with('error', trans('app.resume_file_type_allowed_msg'));
            }

            $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $image_name = strtolower(time() . Str::random(5) . '-' . Functions::str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

            $imageFileName = 'uploads/resume/' . $image_name;
            try {
                //Upload original image
                Storage::disk('public')->put($imageFileName, file_get_contents($image));

                $application_data = [
                    'job_id' => $request->job_id,
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'message' => $request->message,
                    'resume' => $image_name,
                ];
                ResumesRepo::create($application_data);

                // session()->forget('job_validation_fails');
                return redirect()->route('view_resumes_repo')->withInput($request->input())->with('success', trans('app.resumes_add_success_msg'));
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
            }
        }

        return redirect()->back()->withInput($request->input())->with('error', trans('app.error_msg'));
    }
    public function downloadZip(Request $request)
    {
        $applications = ResumesRepo::orderBy('id', 'desc')->paginate(10);

        $zipFileName = "applicants-resumes-" . time() . ".zip";
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE);

        foreach ($applications as $file) {
            $path = '/uploads/resume/' . $file->resume;
            $filePath = Storage::disk('public')->path($path);
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"'
        ];
        $file_path = public_path($zipFileName);
        $response = response()->make(file_get_contents($file_path), 200, $headers);

        unlink($file_path);

        return $response;
    }
}
