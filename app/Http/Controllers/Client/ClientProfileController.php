<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ClientProfileRequest;

class ClientProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Client::findOrFail($id);
        $profile = ClientProfile::where('client_id', $id)->first();
        return view('client.profiles.edit', compact('user', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientProfileRequest  $request, $id)
    {
        $input = $request->all();
        $user = Client::findOrFail($id);
        $profile = ClientProfile::where('client_id', $id)->first();
        if (ClientProfile::where('client_id', '=', $id)->count() > 0) {
            if ($request->hasFile('profile_pic')) {
                $profile_pic = $request->file('profile_pic');
                $fileName = $profile_pic->getClientOriginalName();
                $profile->update($input);
                $uploadDir = 'uploads/profiles/clients/' . $id;
                $profile_pic->move($uploadDir, $fileName);
                $profile->profile_pic = $uploadDir . '/' . $fileName;
                $profile->save();
                return redirect()->back()
                    ->with('success', 'تم تحديث البيانات الشخصية بنجاح');
            }
            else{
                $profile->update($input);
                return redirect()->back()->with('success','تم تحديث البيانات الشخصية بنجاح');
            }
        } else {
            if ($request->hasFile('profile_pic')) {
                $profile_pic = $request->file('profile_pic');
                $fileName = $profile_pic->getClientOriginalName();
                $user->profile()->create($input);
                $uploadDir = 'uploads/profiles/clients/' . $id;
                $profile_pic->move($uploadDir, $fileName);
                $profile->profile_pic = $uploadDir . '/' . $fileName;
                $profile->save();
                return redirect()->back()->with('success','تم تحديث البيانات الشخصية بنجاح');
            }
            else{
                $user->profile()->create($input);
                return redirect()->back()->with('success','تم تحديث البيانات الشخصية بنجاح');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClientProfile $profile
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request  $request, $id)
    {
        // dd($request);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = Client::findOrFail($id);
        $user->update($input);
        $user->assignRole($request->input('role_name'));
        return redirect()->back()->with('success','تم تحديث البيانات الاساسية بنجاح');
    }
}
