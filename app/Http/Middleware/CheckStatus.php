<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    public function handle($request, Closure $next)
    {
        $guard = "client-web";
        if (Auth::guard($guard)->check()){
            $company_id = Auth::user()->company_id;
            $company = Company::FindOrFail($company_id);
            $subscription = $company->subscription;
            $status = $company->status;
            if ($status == "blocked") {
                return redirect()->route('index')->with('error','
                يلزم التواصل مع الادارة لتفعيل الاشتراك');
            }
            else{
                $today = date('Y-m-d');
                if ($today >= $subscription->end_date){
                    $subscription->update([
                        'status' => 'blocked'
                    ]);
                    $company->update([
                        'status' => 'blocked'
                    ]);
                    return redirect()->route('index')->with('error','يلزم التواصل مع الادارة لتفعيل الاشتراك');
                }
            }
        }
        return $next($request);
    }
}
