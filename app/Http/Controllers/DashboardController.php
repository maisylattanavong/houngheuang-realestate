<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Realestate;
use App\Models\RegionName;
use App\Models\VisitorCount;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    public function Dashboard(Request $request)
    {
        $path = Storage::path('public/media');
        if (!Storage::exists($path)) {
            Storage::makeDirectory('public/media');
        }

        // $allposts = Post::all();
        // $posts = Post::latest()->limit(3)->get();
        $allRealestates = Realestate::all();
        $realestates = Realestate::where('publish', '1')->latest()->limit(3)->get();

        $categories = Category::all();
        $category_id = Category::where('id', 'category_id')->orderBy('id', 'DESC')->get();
        $users = User::all();

        $allVisitors = VisitorCount::all();

        // country name count
        $country_names = DB::table('visitor_counts')
            ->select(DB::raw('count(*) as country_count, countryName'))
            ->where('countryName', '<>', 1)
            ->groupBy('countryName')
            ->get();
        foreach ($country_names as $country_name) {
            $data_country[] = array(
                'label' => $country_name->countryName,
                'y' => $country_name->country_count,
            );
        }


        //region name or province name
        $regionNameStatistics = RegionName::all();
        foreach ($regionNameStatistics as $regionNameStatistic) {
            $data[] = array(
                'label' => $regionNameStatistic->regionName,
                'y' => $regionNameStatistic->totalVisitor,
            );
        }
        // query years for option selection
        $years = DB::table('visitor_counts')->selectRaw('YEAR(created_at) as year, count(*) as total')
            ->groupBy('year')->get();

        return view('admin.index', compact(
            'allRealestates',
            'categories',
            'users',
            'realestates',
            'category_id',
            'allVisitors',
            'data',
            'data_country',
            'years'
        ));
    } //end method



    public function ViewPostCat(Request $request)
    {
        $id = $request->id;
        $cat_name = $request->cat_name;
        $allposts = Post::all();
        $categories = Category::all();
        $users = User::all();
        $post_cats = Post::where('category_id', $id)->get();
        return view('admin.view_post_cat', compact('post_cats', 'categories', 'allposts', 'users', 'cat_name'));
    } //end method


    public function ViewPropertyCat(Request $request)
    {
        $id = $request->id;
        $cat_name = $request->cat_name;
        $allProperties = Realestate::all();
        $categories = Category::all();
        $users = User::all();
        $property_cats = Realestate::where('category_id', $id)->get();

        return view('admin.view_property_cat', compact(
            'property_cats',
            'categories',
            'allProperties',
            'users',
            'cat_name'
        ));
    } //end method

    // query data for statistics chart
    public function queryData(Request $request)
    {
        $year = $request->year;
        $months = DB::table('visitor_counts')
            ->selectRaw('YEAR(created_at) as year,  MONTH(created_at) as month, count(*) as total')
            ->whereYear('created_at', '=', $year)
            ->groupBy('year', 'month')
            ->get();

        foreach ($months as $month) {
            $data_year[] = array(
                'label' => Carbon::createFromFormat('m', $month->month)->format('F'),
                // 'label' => $month->month,
                'y' => intval($month->total),
            );
        }
        return response()->json($data_year);
    }
}
