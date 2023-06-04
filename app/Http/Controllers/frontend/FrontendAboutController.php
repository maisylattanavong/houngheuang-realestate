<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyMultiImage;
use App\Models\Socialmedia;

class FrontendAboutController extends Controller
{
    public function HomeAbout()
    {
        $aboutpage = Company::first();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();


        $company_images = CompanyMultiImage::all();

        return view('frontend.about.about_company', compact(
            'aboutpage',
            'company_images',
            'social',
            'line',
            'footer'
        ));
    }
}
