<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminProfile;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Information;
use App\Models\IntroMovie;
use App\Models\Subscription;
use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth:admin-web');
    }

    public function index()
    {
        $auth_id = Auth::user()->id;
        $user = Admin::findOrFail($auth_id);

        if (AdminProfile::where('admin_id', '=', $auth_id)->count() > 0) {
            //profile found
        } else {
            // profile not found
            $user->assignRole($user->role_name);
            $profile = AdminProfile::create([
                'phone_number' => '',
                'city_name' => '',
                'age' => '',
                'gender' => '',
                'profile_pic' => 'app-assets/images/logo.png',
                'admin_id' => $auth_id
            ]);
        }
        $companies = Company::all();
        $trial = Type::where('type_name', 'تجربة')->first();
        $trial_subscriptions = Subscription::where('type_id', $trial->id)->where('status', 'active')->get();
        $about_end_subscriptions = Subscription::where('end_date','LIKE','%'.date('Y-m').'%')->where('status', 'active')->get();
        $active_subscriptions = Subscription::where('status', 'active')->get();
        $not_trial_subscriptions = Subscription::where('type_id','!=', $trial->id)->get();
        return view('admin.home', compact('user','active_subscriptions',
            'trial_subscriptions','about_end_subscriptions', 'companies','not_trial_subscriptions'));
    }
    public function social_links()
    {
        $social = Information::FindOrFail(1);
        return view('admin.social', compact('social'));
    }

    public function update_social_links(Request $request)
    {
        $data = $request->all();
        $social = Information::FindOrFail(1);
        $social->update($data);
        return redirect()->route('social.links')->with('success', 'تم حفظ معلومات مواقع التواصل الاجتماعى بنجاح');
    }
    public function intro_movie()
    {
        $intro_movie = IntroMovie::first();
        return view('admin.intro.movie', compact('intro_movie'));
    }

    public function intro_movie_post(Request $request)
    {
        if ($request->hasFile('intro_movie')) {
            $intro = $request->file('intro_movie');
            $fileName = $fileName = $intro->getClientOriginalName();
            $uploadDir = 'uploads/intro/';
            $full_path = $uploadDir . $fileName;
            $intro->move($uploadDir, $fileName);
            $check = IntroMovie::first();
            if (empty($check)) {
                $intro_movie = IntroMovie::create([
                    'intro_movie' => $full_path
                ]);
            } else {
                $check->update([
                    'intro_movie' => $full_path
                ]);
            }
        }
        return redirect()->route('intro')->with('success', 'تم رفع الفيديو بنجاح');
    }
}
