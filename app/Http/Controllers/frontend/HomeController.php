<?php

namespace App\Http\Controllers\frontend;

use App\Models\Post;
use App\Models\Guide;
use App\Models\Banner;
use App\Models\Company;
use App\Models\IpCount;
use App\Models\Category;
use App\Models\Realestate;
use App\Models\RegionName;
use App\Models\Socialmedia;
use App\Models\VisitorCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryTranslation;
use App\Http\Controllers\Controller;
use App\Models\RealestateMultiImage;
use Stevebauman\Location\Facades\Location;

class HomeController extends Controller
{
    public function Home()
    {
        $ip = request()->ip();
        $is_public_ip = Location::get($ip);
        if ($is_public_ip == false) {
            $ip = '115.84.112.140';
        }

        $user_agent = request()->userAgent();
        $allip = VisitorCount::where('ip', $ip)->get();
        $data = Location::get($ip);

        if (count($allip) == 0) {
            $visitor = new VisitorCount();
            $visitor->ip = $ip;
            $visitor->user_agent = $user_agent;
            $visitor->countryName = $data->countryName;

            $visitor->regionName = $data->regionName;
            $visitor->cityName = $data->cityName;
            $visitor->save();

            $regionName = VisitorCount::where('regionName', $data->regionName)->get();
            if ($data->countryName == 'Laos' && count($regionName) == 1) {
                $ipByRegionName = new RegionName();
                $ipByRegionName->countryName = $data->countryName;
                $ipByRegionName->regionName = $data->regionName;
                $ipByRegionName->save();
            } else {
                RegionName::where('regionName', $data->regionName)->update(['totalVisitor' => DB::raw('totalVisitor+1')]);
            }

            $ips = new IpCount();
            $ips->ip = $ip;
            $ips->user_agent = $user_agent;
            $ips->countryName = $data->countryName;
            $ips->countryCode = $data->countryCode;
            $ips->regionCode = $data->regionCode;
            $ips->regionName = $data->regionName;
            $ips->cityName = $data->cityName;
            $ips->latitude = $data->latitude;
            $ips->longitude = $data->longitude;
            $ips->areaCode = $data->areaCode;
            $ips->timezone = $data->timezone;
            $ips->driver = $data->driver;
            $ips->save();
        } else {
            $ips = new IpCount();
            $ips->ip = $ip;
            $ips->user_agent = $user_agent;
            $ips->countryName = $data->countryName;
            $ips->countryCode = $data->countryCode;
            $ips->regionCode = $data->regionCode;
            $ips->regionName = $data->regionName;
            $ips->cityName = $data->cityName;
            $ips->latitude = $data->latitude;
            $ips->longitude = $data->longitude;
            $ips->areaCode = $data->areaCode;
            $ips->timezone = $data->timezone;
            $ips->driver = $data->driver;
            $ips->save();
        }


        $banner_slide = Banner::where('status', "1")->get();
        $count = $banner_slide->count();
        $category = Category::all();
        // $post = Post::latest()->take(4)->get();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $SITE_DOMAIN = env('SITE_DOMAIN');

        $realestates = Realestate::where('publish', '1')->latest()->take(12)->get();
        $slider_properties = Realestate::where('publish', '1')->latest()->take(4)->get();
        $recommended_properties_latest = Realestate::where('publish', '1')->where('recommended_property', '1')->latest()->take(1)->first();
        $recommended_properties = Realestate::where('publish', '1')->where('recommended_property', '1')->latest()->take(4)->get();

        $aboutCompany = Company::first();

        // $realestatesd = Realestate::whereHas('translations', function ($query){
        //     $query->where('locale', '=', 'en')
        //     ->orWhere('title', 'LIKE', "4");
        // })->paginate(2);
        // dd($realestatesd);
        // $multi_images = RealestateMultiImage::where('realestate_id',$request->id)->get();
        // $multi_images_l = RealestateMultiImage::where('realestate_id',$request->id)->skip(1)->take(10)->latest()->get();
        // $last_image_slide = RealestateMultiImage::where('realestate_id',$request->id)->latest()->first();

        // $multi_images_l = Realestate::where('realestate_id',$request->id)->skip(1)->take(10)->latest()->get();
        // dd($realestates);
        // return view('frontend.index', compact(
        //     'realestates',
        //     'banner_slide',
        //     'category',
        //     'post',
        //     'footer',
        //     'social',
        //     'line',
        //     'count',
        //     'SITE_DOMAIN'
        // ));
        return view('frontend.index', compact(
            'realestates',
            'slider_properties',
            'recommended_properties',
            'recommended_properties_latest',
            'aboutCompany',
            'social'
        ));
    } //end home method


    public function Buy()
    {
        // $buys = Realestate::where('publish', '1')->where('category_id', 1)->paginate(6);
        // $hot_buy_properties = Realestate::where('publish', '1')->where('hot_property', '1')
        // ->where('category_id', 1)->latest()->take(4)->get();
        // return view('frontend.buy', compact('buys', 'hot_buy_properties'));
        return view('frontend.buy');
    }


    public function Sale()
    {
        $sales = Realestate::where('publish', '1')->where('category_id', 2)->paginate(6);
        $hot_sale_properties = Realestate::where('publish', '1')->where('hot_property', '1')->where('category_id', 2)->latest()->take(4)->get();
        return view('frontend.sale', compact('sales', 'hot_sale_properties'));
    }

    public function Rent()
    {
        $rents = Realestate::where('publish', '1')->where('category_id', 3)->paginate(6);
        $hot_rent_properties = Realestate::where('publish', '1')->where('hot_property', '1')->where('category_id', 3)->latest()->take(4)->get();
        return view('frontend.rent', compact('rents', 'hot_rent_properties'));
    }

    public function BuySaleRent()
    {
        $allProperties = Realestate::where('publish', '1')->paginate(6);
        return view('frontend.buysalerent', compact('allProperties'));
    }

    public function propertyDetail(Request $request)
    {
        Realestate::find($request->id)->increment('views');
        $detail = Realestate::find($request->id);
        $hot_properties = Realestate::latest()->take(4)->get();
        $multi_images = RealestateMultiImage::where('realestate_id', $request->id)->get();
        $multi_images_l = RealestateMultiImage::where('realestate_id', $request->id)->skip(1)->take(10)->latest()->get();
        $last_image_slide = RealestateMultiImage::where('realestate_id', $request->id)->latest()->first();

        $hot_buy_properties = Realestate::where('publish', '1')->where('hot_property', '1')->where('category_id', 1)->latest()->take(4)->get();
        $hot_sale_properties = Realestate::where('publish', '1')->where('hot_property', '1')->where('category_id', 2)->latest()->take(4)->get();
        $hot_rent_properties = Realestate::where('publish', '1')->where('hot_property', '1')->where('category_id', 3)->latest()->take(4)->get();
        return view('frontend.propertyDetail', compact(
            'detail',
            'hot_properties',
            'multi_images',
            'last_image_slide',
            'multi_images_l',
            'hot_buy_properties',
            'hot_sale_properties',
            'hot_rent_properties'
        ));
    }

    public function PropertyCat(Request $request)
    {

        // $cat = CategoryTranslation::where('name', request()->segment(3))->get();
        // if (!is_null($cat)) {
        //     foreach($cat as $item){
        //     }
        // }
        // $propertyCats = Realestate::where('publish', '1')->where('category_id', $item->category_id)->paginate(6);
        // $hot_properties = Realestate::where('publish', '1')->where('hot_property', '1')->latest()->take(4)->get();
        // return view('frontend.propertyCat', compact('hot_properties'));
            return view('frontend.propertyCat');
    }


    public function allpost(Request $request)
    {
        //search
        $search = request()->query('search');
        $search_post = Post::whereHas('translations', function ($query) use ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        })->get();
        if (count($search_post) == 0) {
            $search_post = Post::whereHas('category', function ($query) use ($search) {
                $query->whereHas('translations', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            })->get();
        }

        $firstPost = Post::latest()->take(1)->get();
        $posts = Post::latest()->skip(1)->take(4)->get();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $categories = Category::all();


        // dd($categories);
        $SITE_DOMAIN = env('SITE_DOMAIN');

        // if has search
        if ($search) {
            return view('frontend.search', compact('posts', 'social', 'line', 'footer', 'categories', 'SITE_DOMAIN', 'search_post', 'firstPost'));
        } else {
            return view('frontend.all_post', compact('posts', 'social', 'line', 'footer', 'categories', 'SITE_DOMAIN', 'search_post', 'firstPost'));
        }
    }


    public function banner($locale, $id)
    {
        $banner = Banner::where('status', "1")->where('id', $id)->first();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        return view('frontend.banner.banner', compact('social', 'line', 'footer', 'banner'));
    }


    public function Guide(){
        $content = Guide::latest()->first();
        return view('frontend.guide',compact('content'));
    }
}
