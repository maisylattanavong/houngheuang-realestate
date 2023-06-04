<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CompanyTranslation;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\CleanTextController;

class CompanyController extends Controller
{

    public function index()
    {
        $company = Company::all();
        if ($company->isEmpty()) {
            return view('admin.company.create');
        } else {
            $companies = $company[0];
            $en_company = CompanyTranslation::where('company_id', $companies->id)->where('locale', 'en')->first();
            $la_company = CompanyTranslation::where('company_id', $companies->id)->where('locale', 'la')->first();
            // dd($en_company, $la_company);
            return view('admin.company.index', compact('en_company', 'la_company', 'companies'));
        }
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'en_name' => 'required',
            'la_name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'website' => 'required',
            'mobile' => 'required|numeric|regex:/^(20)[0-9]{8}$/',
            'telephone' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'fax' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'en_address' => 'required',
            'la_address' => 'required',
            'en_about' => 'required',
            'la_about' => 'required',
            'logo' => 'required|mimes:jpg,png,jfif,JPEG|max:2048',
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

        //store
        $company = Company::create([
            'user_id' => $user_id,
            'email' => $request->email,
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
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'website' => 'required',
            'mobile' => 'required|numeric|regex:/^(20)[0-9]{8}$/',
            'telephone' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'fax' => 'required|numeric|regex:/^(021)[0-9]{7}$/',
            'en_address' => 'required',
            'la_address' => 'required',
            'en_about' => 'required',
            'la_about' => 'required',
        ]);

        $id = $request->id;
        $company_data = Company::findOrfail($id);
        $db_image = $company_data->logo;

        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'required|mimes:jpg,png,jfif,JPEG|max:2048',
            ]);

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

        // clean script function
        $cleanText = new CleanTextController();
        $en_about = $cleanText->ReplaceScriptWithPTag($request->en_about);
        $la_about = $cleanText->ReplaceScriptWithPTag($request->la_about);

        Company::findOrFail($id)->update([
            'user_id' => $user_id,
            'email' => $request->email,
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

        $notification = array(
            'message' => 'Update success', 'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
