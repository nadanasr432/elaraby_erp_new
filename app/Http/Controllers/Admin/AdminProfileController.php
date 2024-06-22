<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminProfileRequest;
use App\Http\Requests\UpdateAdminProfileRequest;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Admin::findOrFail($id);
        $profile = AdminProfile::where('admin_id', $id)->first();
        return view('admin.profiles.edit', compact('user', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAdminProfileRequest $request, $id)
    {
        $input = $request->all();
        $user = Admin::findOrFail($id);
        $profile = AdminProfile::where('admin_id', $id)->first();
        if (AdminProfile::where('admin_id', '=', $id)->count() > 0) {
            if ($request->hasFile('profile_pic')) {
                $profile_pic = $request->file('profile_pic');
                $fileName = $profile_pic->getClientOriginalName();
                $profile->update($input);
                $uploadDir = 'uploads/profiles/admins/' . $id;
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
                $uploadDir = 'uploads/profiles/admins/' . $id;
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

    public function update(UpdateAdminProfileRequest $request, $id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = Admin::findOrFail($id);
        $user->update($input);
        $user->assignRole($request->input('role_name'));
        return redirect()->back()->with('success','تم تحديث البيانات الاساسية بنجاح');
    }
}
