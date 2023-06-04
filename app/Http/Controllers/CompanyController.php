<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Socialmedia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CompanyMultiImage;
use App\Models\CompanyTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

use function PHPUnit\Framework\fileExists;
use App\Http\Controllers\CleanTextController;

class CompanyController extends Controller
{

    public function index(Request $request)
    {

        $company = Company::all();
        if ($company->isEmpty()) {
            return view('admin.company.create');
        } else {
            $companies = $company[0];
            $en_company = CompanyTranslation::where('company_id', $companies->id)->where('locale', 'en')->first();
            $la_company = CompanyTranslation::where('company_id', $companies->id)->where('locale', 'la')->first();
            $cn_company = CompanyTranslation::where('company_id', $companies->id)->where('locale', 'cn')->first();
            $company_images = DB::table('company_multi_images')->where('company_id', $companies->id)->get();
            // dd($en_company, $la_company);
            return view('admin.company.index', compact(
                'en_company',
                'la_company',
                'cn_company',
                'company_images',
                'companies'
            ));
        }
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'logo' => 'required|mimes:jpg,png,jfif,JPEG|max:2048',
            'company_images'=>'required|between:1,2048',
            'en_name' => 'required',
            'la_name' => 'required',
            'cn_name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'map' => 'required',
            'website' => 'required',
            'mobile' => 'required|numeric|regex:/^(20)[0-9]{8}$/',
            'telephone' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'fax' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'en_address' => 'required',
            'la_address' => 'required',
            'cn_address' => 'required',
            'en_about' => 'required',
            'la_about' => 'required',
            'cn_about' => 'required',
        ], [
            'logo' => 'Please choose a logo',
            'company_images'=>'Please choose images',
            'en_name' => 'Please enter English company name',
            'la_name' => 'Please enter Lao company name',
            'cn_name' => 'Please enter Chinese company name',
            'email' => 'Please enter an email',
            'map'=>'Please enter company map information',
            'website' => 'Please enter a website url',
            'mobile' => 'Please enter a correct mobile number',
            'telephone' => 'Please enter a correct telephone number',
            'fax' => 'Please enter correct fax number',
            'en_address' => 'Please enter English company address',
            'la_address' => 'Please enter Lao company address',
            'cn_address' => 'Please enter Chinese company address',
            'en_about' => 'Please enter English company description',
            'la_about' => 'Please enter Lao company description',
            'cn_about' => 'Please enter Chinese company description',
        ]);

        $image = $request->file('logo');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $save_url = 'storage/media/' . $name_gen;

        $img = Image::make($image->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($save_url);



        // clean script function
        $cleanText = new CleanTextController();
        $en_about = $cleanText->ReplaceScriptWithPTag($request->en_about);
        $la_about = $cleanText->ReplaceScriptWithPTag($request->la_about);
        $cn_about = $cleanText->ReplaceScriptWithPTag($request->cn_about);

        //store
        $company = Company::create([
            'user_id' => $user_id,
            'email' => $request->email,
            'map'=>$request->map,
            'website' => $request->website,
            'mobile' => $request->mobile,
            'telephone' => $request->telephone,
            'fax' => $request->fax,
            'logo' => $save_url,
            'status' => 0,
            'created_at' => Carbon::now(),
        ]);
        CompanyTranslation::insert([
            'company_id' => $company->id,
            'locale' => 'en',
            'name' => strip_tags($request->en_name),
            'address' => strip_tags($request->en_address),
            'about' => $en_about,
        ]);

        CompanyTranslation::insert([
            'company_id' => $company->id,
            'locale' => 'la',
            'name' => strip_tags($request->la_name),
            'address' => strip_tags($request->la_address),
            'about' => $la_about,
        ]);

        CompanyTranslation::insert([
            'company_id' => $company->id,
            'locale' => 'cn',
            'name' => strip_tags($request->cn_name),
            'address' => strip_tags($request->cn_address),
            'about' => $cn_about,
        ]);

        if ($request->has('company_images')) {
            foreach ($request->file('company_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());

                $img->resize(1500, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                CompanyMultiImage::insert([
                    'company_id' => $company->id,
                    'image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }


        $notification = array(
            'message' => 'Insert success', 'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'en_name' => 'required',
            'la_name' => 'required',
            'cn_name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'map' => 'required',
            'website' => 'required',
            'mobile' => 'required|numeric|regex:/^(20)[0-9]{8}$/',
            'telephone' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'fax' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'en_address' => 'required',
            'la_address' => 'required',
            'cn_address' => 'required',
            'en_about' => 'required',
            'la_about' => 'required',
            'cn_about' => 'required',
        ], [
            'en_name' => 'Please enter English company name',
            'la_name' => 'Please enter Lao company name',
            'cn_name' => 'Please enter Chinese company name',
            'email' => 'Please enter an email',
            'map'=>'Please enter company map information',
            'website' => 'Please enter a website url',
            'mobile' => 'Please enter a correct mobile number',
            'telephone' => 'Please enter a correct telephone number',
            'fax' => 'Please enter a correct fax number',
            'en_address' => 'Please enter English company address',
            'la_address' => 'Please enter Lao company address',
            'cn_address' => 'Please enter Chinese company address',
            'en_about' => 'Please enter English company description',
            'la_about' => 'Please enter Lao company description',
            'cn_about' => 'Please enter Chinese company description',
        ]);

        $id = $request->id;
        $company_data = Company::findOrfail($id);
        $db_image = $company_data->logo;

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;

            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Company::findOrFail($id)->update([
                'logo' => $save_url,
            ]);

            unlink($db_image);
        }

        if ($request->has('company_images')) {
            foreach ($request->file('company_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());

                $img->resize(1500, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                CompanyMultiImage::insert([
                    'company_id' => $company_data->id,
                    'image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        // clean script function
        $cleanText = new CleanTextController();
        $en_about = $cleanText->ReplaceScriptWithPTag($request->en_about);
        $la_about = $cleanText->ReplaceScriptWithPTag($request->la_about);
        $cn_about = $cleanText->ReplaceScriptWithPTag($request->cn_about);

        Company::findOrFail($id)->update([
            'user_id' => $user_id,
            'email' => $request->email,
            'map'=>$request->map,
            'website' => $request->website,
            'mobile' => $request->mobile,
            'telephone' => $request->telephone,
            'fax' => $request->fax,
            'updated_at' => Carbon::now(),
        ]);

        CompanyTranslation::findOrFail($request->en_id)->update([
            'name' => strip_tags($request->en_name),
            'address' => strip_tags($request->en_address),
            'about' => $en_about,
        ]);

        CompanyTranslation::findOrFail($request->la_id)->update([
            'name' => strip_tags($request->la_name),
            'address' => strip_tags($request->la_address),
            'about' => $la_about,
        ]);

        CompanyTranslation::findOrFail($request->cn_id)->update([
            'name' => strip_tags($request->cn_name),
            'address' => strip_tags($request->cn_address),
            'about' => $cn_about,
        ]);

        $notification = array(
            'message' => 'Update success', 'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// end method



    public function deleteCompanySingleImage(Request $request){
        $id = $request->id;
        $single_image = CompanyMultiImage::findOrFail($id);
        if(fileExists($single_image->image)){
            $single_image->delete();
            unlink($single_image->image);
        }
        $notifiction = array(
            'message' => 'Delete Image Successfully', 'alert-type' => 'success'
        );

        return redirect()->back()->with($notifiction);
    }

    public function aboutCompany()
    {
        $aboutCompany = Company::first();
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
