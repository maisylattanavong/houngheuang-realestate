<?php

namespace App\Http\Controllers\frontend;

use App\Models\Socialmedia;
use App\Models\CompanyMultiImage;
use App\Models\Company;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function AboutCompany()
    {
        $aboutCompany = Company::first();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();


        $company_images = CompanyMultiImage::all();

        return view('frontend.about.about_company', compact(
            'aboutCompany',
            'company_images',
            'social',
            'line',
            'footer'
        ));
    }
}
