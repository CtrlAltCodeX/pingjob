<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helper\Functions;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        $title = trans('app.categories');
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('admin.categories', compact('title', 'categories'));
    }



    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required',
        ];
        $this->validate($request, $rules);

        $slug = Functions::str_slug($request->category_name);
        $duplicate = Category::where('category_slug', $slug)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.category_exists_in_db'));
        }

        $data = [
            'category_name' => $request->category_name,
            'category_slug' => $slug,
        ];

        Category::create($data);
        return back()->with('success', trans('app.category_created'));
    }


    public function edit($id)
    {
        $title = trans('app.edit_category');
        $category = Category::find($id);

        return view('admin.edit_category', compact('title', 'category'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'category_name' => 'required'
        ];
        $this->validate($request, $rules);

        $slug = Functions::str_slug($request->category_name);

        $duplicate = Category::where('category_slug', $slug)->where('id', '!=', $id)->count();
        if ($duplicate > 0) {
            return back()->with('error', trans('app.category_exists_in_db'));
        }

        $data = [
            'category_name' => $request->category_name,
            'category_slug' => $slug,
        ];
        Category::where('id', $id)->update($data);
        return back()->with('success', trans('app.category_updated'));
    }


    public function destroy(Request $request)
    {
        $id = $request->data_id;

        $delete = Category::where('id', $id)
            ->delete();

        $jobApp = JobApplication::select('id', 'email')
            ->where('category_id', $id)
            ->groupBy('email')
            ->pluck('id')
            ->toArray();

        JobApplication::whereNotIn('id', $jobApp)
            ->where('category_id', $id)
            ->delete();

        // Job::where('category_id', $id)
        //     ->get();

        if ($delete) {
            return ['success' => 1, 'msg' => trans('app.category_deleted_success')];
        }
        return ['success' => 0, 'msg' => trans('app.error_msg')];
    }
}
