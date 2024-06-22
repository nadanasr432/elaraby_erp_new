<?php

namespace App\Http\Controllers\Site;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;

class ContactController extends Controller
{
    public function send_message(SendMessageRequest  $request)
    {
        Contact::create($request->all());
        return redirect()->back()->with('success','تم ارسال رسالتك الى الادارة');
    }
}
