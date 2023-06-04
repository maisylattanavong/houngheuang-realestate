<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'contactName' => 'required',
            'contactEmail' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'contactPhone' => 'required|numeric|digits:10',
            'conWhatsapp' => 'required|numeric|digits:10',
            'conlineId' => 'required'

        ]);

        $contact = new Contact();
        if ($request) {
            $is_notExitsData = Contact::where('name', $request->contactName) && Contact::where('email', $request->contactEmail) && Contact::where('phone', $request->contactPhone)->doesntExist();
            if ($is_notExitsData) {
                $contact->name = $request->contactName;
                $contact->email = $request->contactEmail;
                $contact->phone = $request->contactPhone;
                $contact->whatsapp = $request->conWhatsapp;
                $contact->lineid = $request->conlineId;

                $contact->save();
                $notification = array(
                    'message' => 'Insert success', 'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => 'Data exits please try again !', 'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }
    }


    public function show($id)
    {
        dd($id);
        $contact = DB::table('contacts')->find($id);
        return response()->json($contact);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $updateContact = Contact::find($id);
        if ($request) {
            $queryData = DB::table("contacts")->where('id', $id)->get();
            // dd($queryData);
            if ($queryData) {

                $updateContact->name = $request->updateName;
                $updateContact->email = $request->updateEmail;
                $updateContact->phone = $request->updatePhone;
                $updateContact->whatsapp = $request->updateWhatsapp;
                $updateContact->lineid = $request->updateLineId;

                $updateContact->update();
            }

            $notification = array(
                'message' => 'Insert success', 'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $request->validate(['updateName' => 'required']);
        }
    }

    public function destroy($id)
    {

        DB::table('contacts')->where('id', $id)->delete();
        return redirect()->back()->with('status');
    }
}
