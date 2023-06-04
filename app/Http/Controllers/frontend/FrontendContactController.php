<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Socialmedia;

class FrontendContactController extends Controller
{
    public function HomeContact()
    {
        $contact = Company::first();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        return view('frontend.contact.contact_all', compact('contact', 'footer', 'social','line'));
    }
}