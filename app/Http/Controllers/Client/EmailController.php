<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\EmailSettings;
use App\Models\OuterClient;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\sendingEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function emails_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $products = Product::where('company_id', $company_id)->get();
        return view('client.emails.clients', compact('company_id', 'company', 'outer_clients', 'products'));
    }

    public function send_client_email(Request $request)
    {
        $outer_client_ids = $request->outer_client_id;
        $body = nl2br($request->body);
        $subject = $request->subject;
        $files = $request->file('files');
        $images = $request->check;
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $email_setting = EmailSettings::where('company_id', $company_id)->first();
        $data = array(
            'outer_client_ids' => $outer_client_ids,
            'body' => $body,
            'files' => $files,
            'images' => $images,
            'subject' => $subject,
        );
        foreach ($outer_client_ids as $outer_client_id){
            $outer_client = OuterClient::FindOrFail($outer_client_id);
            $client_email = $outer_client->client_email;
            Mail::to($client_email)->send(new sendingEmail($data));
        }

        return redirect()->route('client.emails.clients')
            ->with('success', 'تم ارسالة الرسالة بنجاح');
    }

    public function emails_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $products = Product::where('company_id', $company_id)->get();
        return view('client.emails.suppliers', compact('company_id', 'company', 'suppliers', 'products'));
    }

    public function send_supplier_email(Request $request)
    {
        $supplier_ids = $request->supplier_id;
        $body = nl2br($request->body);
        $subject = $request->subject;
        $files = $request->file('files');
        $images = $request->check;
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $email_setting = EmailSettings::where('company_id', $company_id)->first();
        $data = array(
            'supplier_ids' => $supplier_ids,
            'body' => $body,
            'files' => $files,
            'images' => $images,
            'subject' => $subject,
        );
        foreach ($supplier_ids as $supplier_id){
            $supplier = Supplier::FindOrFail($supplier_id);
            $supplier_email = $supplier->supplier_email;
            Mail::to($supplier_email)->send(new sendingEmail($data));
        }

        return redirect()->route('client.emails.suppliers')
            ->with('success', 'تم ارسالة الرسالة بنجاح');
    }

}
