<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Currency;
use App\Models\ExtraSettings;
use App\Models\Fiscal;
use App\Models\PosSetting;
use App\Models\Screen;
use App\Models\Tax;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Ramsey\Uuid\v1;

class SettingsController extends Controller
{
    public function screens_settings()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $screens = Screen::where('company_id', $company_id)->get();
        $branches = $company->branches;
        return view('client.settings.screens', compact('company', 'branches', 'screens'));
    }

    public function screens_settings_edit($id)
    {
        $screen = Screen::FindOrFail($id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = $company->branches;
        return view('client.settings.edit_screens', compact('screen', 'company_id', 'company', 'branches'));
    }

    public function screens_settings_update(Request $request)
    {
        $screen_id = $request->screen_id;
        $screen_settings = Screen::findOrFail($screen_id);
        $screens = $request->screens;
        $screen_settings->update($request->all());
        if (in_array('products', $screens)) {
            $screen_settings->products = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->products = "0";
            $screen_settings->save();
        }
        if (in_array('debt', $screens)) {
            $screen_settings->debt = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->debt = "0";
            $screen_settings->save();
        }
        if (in_array('banks_safes', $screens)) {
            $screen_settings->banks_safes = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->banks_safes = "0";
            $screen_settings->save();
        }
        if (in_array('sales', $screens)) {
            $screen_settings->sales = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->sales = "0";
            $screen_settings->save();
        }
        if (in_array('purchases', $screens)) {
            $screen_settings->purchases = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->purchases = "0";
            $screen_settings->save();
        }
        if (in_array('finance', $screens)) {
            $screen_settings->finance = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->finance = "0";
            $screen_settings->save();
        }
        if (in_array('marketing', $screens)) {
            $screen_settings->marketing = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->marketing = "0";
            $screen_settings->save();
        }
        if (in_array('accounting', $screens)) {
            $screen_settings->accounting = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->accounting = "0";
            $screen_settings->save();
        }
        if (in_array('reports', $screens)) {
            $screen_settings->reports = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->reports = "0";
            $screen_settings->save();
        }
        if (in_array('settings', $screens)) {
            $screen_settings->settings = "1";
            $screen_settings->save();
        }
        else{
            $screen_settings->settings = "0";
            $screen_settings->save();
        }
        return redirect()->route('screens.settings')->with('success','تم حفظ التغييرات بنجاح');
    }

    public function pos_settings()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $pos_settings = PosSetting::where('company_id', $company_id)->get();
        $branches = $company->branches;
        return view('client.settings.pos', compact('company', 'branches','pos_settings'));
    }

    public function pos_settings_edit($id)
    {
        $pos_setting = PosSetting::FindOrFail($id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = $company->branches;
        return view('client.settings.edit_pos', compact('pos_setting', 'company_id', 'company', 'branches'));
    }

    public function pos_settings_update(Request $request)
    {
        $pos_setting_id = $request->pos_setting_id;
        $pos_settings = PosSetting::findOrFail($pos_setting_id);
        $pos = $request->pos;
        $pos_settings->update($request->all());
        if (in_array('status', $pos)) {
            $pos_settings->status = "open";
            $pos_settings->save();
        }
        else{
            $pos_settings->status = "closed";
            $pos_settings->save();
        }
        if (in_array('discount', $pos)) {
            $pos_settings->discount = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->discount = "0";
            $pos_settings->save();
        }
        if (in_array('tax', $pos)) {
            $pos_settings->tax = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->tax = "0";
            $pos_settings->save();
        }
        if (in_array('suspension', $pos)) {
            $pos_settings->suspension = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->suspension = "0";
            $pos_settings->save();
        }
        if (in_array('payment', $pos)) {
            $pos_settings->payment = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->payment = "0";
            $pos_settings->save();
        }
        if (in_array('print_save', $pos)) {
            $pos_settings->print_save = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->print_save = "0";
            $pos_settings->save();
        }
        if (in_array('cancel', $pos)) {
            $pos_settings->cancel = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->cancel = "0";
            $pos_settings->save();
        }
        if (in_array('suspension_tab', $pos)) {
            $pos_settings->suspension_tab = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->suspension_tab = "0";
            $pos_settings->save();
        }
        if (in_array('edit_delete_tab', $pos)) {
            $pos_settings->edit_delete_tab = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->edit_delete_tab = "0";
            $pos_settings->save();
        }
        if (in_array('add_outer_client', $pos)) {
            $pos_settings->add_outer_client = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->add_outer_client = "0";
            $pos_settings->save();
        }


        if (in_array('add_product', $pos)) {
            $pos_settings->add_product = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->add_product = "0";
            $pos_settings->save();
        }

        if (in_array('fast_finish', $pos)) {
            $pos_settings->fast_finish = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->fast_finish = "0";
            $pos_settings->save();
        }

        if (in_array('product_image', $pos)) {
            $pos_settings->product_image = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->product_image = "0";
            $pos_settings->save();
        }

        //enable tableNum field in db
        if (in_array('tableNum', $pos)) {
            $pos_settings->enableTableNum = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->enableTableNum = "0";
            $pos_settings->save();
        }

        //enableProdInvoice field in db فاتورة الاعداد
        if (in_array('enableProdInvoice', $pos)) {
            $pos_settings->enableProdInvoice = "1";
            $pos_settings->save();
        }
        else{
            $pos_settings->enableProdInvoice = "0";
            $pos_settings->save();
        }
        return redirect()->route('pos.settings')->with('success','تم حفظ التغييرات بنجاح');
    }






    public function basic()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.settings.basic', compact('company'));
    }

    public function update_basic(Request $request)
    {
        $company = Company::FindOrFail($request->company_id);
        $company->update($request->all());
        $company->basic_settings->update($request->all());
        if ($request->hasFile('company_logo')) {
            $company_logo = $request->file('company_logo');
            $fileName = $company_logo->getClientOriginalName();
            $uploadDir = 'uploads/companies/logos/' . $company->id;
            $company_logo->move($uploadDir, $fileName);
            $company->company_logo = $uploadDir . '/' . $fileName;
            $company->save();
        }
        if ($request->hasFile('header')) {
            $header = $request->file('header');
            $fileName = $header->getClientOriginalName();
            $uploadDir = 'uploads/companies/headers/' . $company->id;
            $header->move($uploadDir, $fileName);
            $company->basic_settings->header = $uploadDir . '/' . $fileName;
            $company->basic_settings->save();
        }

        if ($request->hasFile('footer')) {
            $footer = $request->file('footer');
            $fileName = $footer->getClientOriginalName();
            $uploadDir = 'uploads/companies/footers/' . $company->id;
            $footer->move($uploadDir, $fileName);
            $company->basic_settings->footer = $uploadDir . '/' . $fileName;
            $company->basic_settings->save();
        }

        if ($request->hasFile('electronic_stamp')) {
            $electronic_stamp = $request->file('electronic_stamp');
            $fileName = $electronic_stamp->getClientOriginalName();
            $uploadDir = 'uploads/companies/electronic_stamps/' . $company->id;
            $electronic_stamp->move($uploadDir, $fileName);
            $company->basic_settings->electronic_stamp = $uploadDir . '/' . $fileName;
            $company->basic_settings->save();
        }

        return redirect()->route('client.basic.settings.edit')->with('success', 'تم تحديث البيانات الاساسية بنجاح');
    }

    public function billing()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $fiscal = Fiscal::where('company_id', $company_id)->first();
        $taxes = Tax::where('company_id', $company_id)->get();
        return view('client.settings.billing', compact('company', 'taxes', 'fiscal'));
    }

    public function update_billing(Request $request)
    {
        $company = Company::FindOrFail($request->company_id);
        $company->update($request->all());
        return redirect()->route('client.billing.settings.edit')->with('success', 'تم تحديث بيانات الفواتير والضرايب بنجاح');
    }

    public function update_fiscal(Request $request)
    {
        $company = Company::FindOrFail($request->company_id);
        $company->fiscal->update($request->all());
        return redirect()->route('client.billing.settings.edit')->with('success', 'تم تحديث بيانات السنة المالية بنجاح');
    }

    public function extra()
    {
        $company_id = Auth::user()->company_id;
        $extra = ExtraSettings::where('company_id', $company_id)->first();
        $company = Company::FindOrFail($company_id);
        $timezones = TimeZone::all();
        $currencies = Currency::all();
        return view('client.settings.extra', compact('extra', 'company', 'timezones', 'currencies'));
    }

    public function update_extra(Request $request)
    {
        $company = Company::FindOrFail($request->company_id);
        $company->extra_settings->update($request->all());
        return redirect()->route('client.extra.settings.edit')->with('success', 'تم تحديث البيانات الاضافية بنجاح');
    }

    public function store_tax(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        $tax = Tax::create($data);
        return redirect()->route('client.billing.settings.edit')->with('success', 'تم اضافة الضريبة بنجاح');
    }

    public function delete_tax(Request $request)
    {
        $tax = Tax::FindOrFail($request->tax_id)->delete();
        return redirect()->route('client.billing.settings.edit')->with('success', 'تم حذف الضريبة بنجاح');
    }


    public function backup()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.settings.backup', compact('company'));
    }
    public function product_expires()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.settings.product_expires', compact('company'));
    }
    public function update_product_expires(Request $request)
    {
        $company = Company::FindOrFail($request->company_id);
        $company->extra_settings->update($request->all());
        return back()->with('success', 'تم تحديث مدة انتهاء صلاحية المتجات بنجاح');
    }


    public function get_backup()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $dbHost = 'localhost';
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');
        $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
        $conn->set_charset("utf8");
        $tables = array();
        $result = mysqli_query($conn, "SELECT * FROM `tables`");
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[1];
        }
        $sqlScript = "";
        foreach ($tables as $table) {
            $result = mysqli_query($conn, "SELECT * FROM `$table` WHERE `company_id` = '$company_id' ");
            if (mysqli_num_rows($result) > 0) {
                $columnCount = mysqli_num_fields($result);
                // Prepare SQLscript for dumping data for each table
                for ($i = 0; $i < $columnCount; $i++) {
                    while ($row = mysqli_fetch_row($result)) {
                        $sqlScript .= "INSERT INTO `$table` VALUES(";
                        for ($j = 0; $j < $columnCount; $j++) {
                            $row[$j] = $row[$j];

                            if (isset($row[$j])) {
                                $sqlScript .= "'" . $row[$j] . "'";
                            } else {
                                $sqlScript .= '""';
                            }
                            if ($j < ($columnCount - 1)) {
                                $sqlScript .= ',';
                            }
                        }
                        $sqlScript .= ");\n";
                    }
                }
//                $sqlScript .= "\n";
            }
        }

        if (!empty($sqlScript)) {
            // Save the SQL script to a backup file
            $backup_file_name = $company->company_name . '_' . date('Y-m-d') . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);
            // Download the SQL backup file to the browser
            header('Content-type: file/txt');
            // It will be called downloaded.pdf
            header("Content-Disposition: attachment; filename=" . $backup_file_name . "");
            // The PDF source is in original.pdf
            readfile($backup_file_name);
        }
    }

    public function restore(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $target_dir = "";
        $target_file = $target_dir . basename($_FILES["sql_file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "sql") {
            echo "مسموح فقط لملفات قواعد البيانات من النوع .SQL ";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "عذرا .. لم يتم رفع الملف";
        } else {
            if (move_uploaded_file($_FILES["sql_file"]["tmp_name"], $target_file)) {
//                echo "الملف " . basename($_FILES["sql_file"]["name"]) . " تم رفعه بنجاح ";
            } else {
                echo "عذرا .. هناك خطأ حدث اثناء رفع الملف ";
            }
        }
        $filename = basename($_FILES["sql_file"]["name"]);
        $mysql_host = 'localhost';
        $mysql_username = env('DB_USERNAME');
        $mysql_password = env('DB_PASSWORD');
        $mysql_database = env('DB_DATABASE');
        $conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($conn));
        mysqli_set_charset($conn, 'utf8');
        mysqli_select_db($conn, $mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($conn));

        $tables = array();
        $result = mysqli_query($conn, "SELECT * FROM `tables`");
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[1];
        }
        foreach ($tables as $table) {
            $qry = mysqli_query($conn, "DELETE FROM `$table` WHERE `company_id` = '$company_id' ");
        }

        $templine = '';
        $lines = file($filename);
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                mysqli_query($conn, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($conn) . '<br /><br />');
                $templine = '';
            }
        }
        return redirect()->route('client.backup.settings.edit')->with('success', 'تم رفع النسخة الاحتياطية بنجاح');
    }


}
