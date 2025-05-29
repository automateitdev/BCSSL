<?php

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Attribute;
use App\Models\Warehouse;
use App\Models\SystemSettings;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use GeoSot\EnvEditor\Facades\EnvEditor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


/**
 * generateSlug
 *
 * @param  mixed $value
 * @return void
 */
function generateSlug($value)
{
    try {
        return preg_replace('/\s+/u', '-', trim($value));
    } catch (\Exception $e) {
        return '';
    }
}

if (!function_exists('get_page_meta')) {

    function get_page_meta($metaName = "title", $raw=false)
    {
        if (session()->has('page_meta_' . $metaName)) {
            $title = session()->get("page_meta_" . $metaName);
//            session()->forget("page_meta_" . $metaName);
            if ($raw){
                return str_replace(' |', '', $title);
            }else{
                return $title;
            }
        }
        return null;
    }
}

if (!function_exists('set_page_meta')) {
    function set_page_meta($content = null, $metaName = "title")
    {
        if ($content && $metaName == "title") {
            session()->put('page_meta_' . $metaName, $content . ' |');
        } else {
            session()->put('page_meta_' . $metaName, $content);
        }
    }
}

// ********* Falsh Message Fro toster ***************
if (!function_exists('message_send_flash')) {

    function message_send_flash($message = null)
    {
        Session::flash('message', $message ?? 'Your message was sent successfully');
    }
}

if (!function_exists('record_warning_flash')) {

    function record_warning_flash($message = null)
    {
        Session::flash('warning', $message ?? 'Record created successfully');
    }
}

if (!function_exists('record_created_flash')) {

    function record_created_flash($message = null)
    {
        Session::flash('success', $message ?? 'Record created successfully');
    }
}

if (!function_exists('record_updated_flash')) {

    function record_updated_flash($message = null)
    {
        Session::flash('update', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('record_verified_flash')) {

    function record_verified_flash($message = null)
    {
        Session::flash('verified', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('file_uploaded_flash')) {

    function file_uploaded_flash($message = null)
    {
        Session::flash('file_uploaded', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('record_deleted_flash')) {

    function record_deleted_flash($message = null)
    {
        Session::flash('delete', $message ?? 'Record deleted successfully');
    }
}

if (!function_exists('something_wrong_flash')) {

    function something_wrong_flash($message = null)
    {
        Session::flash('error', $message ?? 'Something is wrong!');
    }
}
// ********* Falsh Message Fro toster(end) ***************

if (!function_exists('get_file_extention')) {

    function get_file_extention($filename)
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    }
}

if (!function_exists('get_storage_image')) {

    function get_storage_image($path, $name, $type = 'normal')
    {
        $full_path = '/storage/' . $path . '/' . $name;
        if ($name) {
            return asset($full_path);
        }
        return get_default_image($type);
    }
}

if (!function_exists('get_storage_image_public_path')) {

    function get_storage_image_public_path($path, $name, $type = 'normal')
    {
        $full_path = '/storage/' . $path . '/' . $name;
        if ($name) {
            return public_path($full_path);
        }
        return get_default_image($type);
    }
}

if (!function_exists('getImage')) {
    function getImage($image = null, $type = null)
    {
        // dd($image, Storage::disk('public')->exists($image), Storage::disk('public')->url($image));
        if ($image && Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->url($image);
        } else {
            return get_default_image($type);
        }
    }
}



if (!function_exists('get_pdf_image')) {

    function get_pdf_image()
    {
        return asset('assets/images/pdf_dummy.png');

    }
}

if (!function_exists('get_default_image')) {

    function get_default_image($type = 'normal')
    {
        if ($type == 'user') {
            return asset('/assets/images/dummy_pp_image.jpg');
        } elseif ($type == 'normal') {
            return asset('/assets/images/dummy_pp_image.jpg');
        }
         else {
            return asset('/assets/images/dummy_pp_image.jpg');
        }
    }
}


if (!function_exists('random_6d_number')) {

    function random_6d_number()
    {
        return sprintf("%06d", mt_rand(1, 999999));
    }
}
if (!function_exists('numberToSentence')) {

     function numberToSentence($number)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($number));
    }
}

function make8digits($num)
{
    return sprintf("%08d", $num);
}

if (!function_exists('invoiceNoGenerate')) {

    function invoiceNoGenerate()
    {
        return date('YmdHis');
    }
}

if (!function_exists('qr_text_generate')) {

    function now_is_grater_old_date($oldDate)
    {
         $db_date = Carbon::parse($oldDate)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        return  $now > $db_date;
    }
}

if (!function_exists('role_select_all_check')) {

    function role_select_all_check($permissions, $p_type, $role)
    {
        foreach($permissions as $permission){
            if($permission->parent_id == null){
                // dd($permission->children);
                foreach($permission->children as $permission_children){
                    foreach($permission_children->children as $key_sub_chilren => $sub_children){
                        if(str_contains($sub_children->name, $p_type) &&  !$role->hasPermissionTo($sub_children->name)){
                            return false;
                            break;
                        }
                    }

                }
            }
        }
        return true;
    }

    if (!function_exists('qr_text_generate')) {
    function qr_text_generate($paymentInfo)
    {
        $text = '';
        $payment_date = \Carbon\Carbon::parse($paymentInfo->payment_date)->format('j F, Y');
        $qr_code_infos = [
            'Member Name : ' . $paymentInfo->member->name,
            'Member Id : ' . $paymentInfo->member->associatorsInfo->membershp_number,
            'Invoice Id : ' . $paymentInfo->invoice_no,
            'Paid Amount : ' . $paymentInfo->total_amount,
            'Payment Date : ' . $payment_date
        ];
        foreach($qr_code_infos as $qr_code_info) {
            $text = $text . "\n" . $qr_code_info;
        }
        return $text;
    }
}




    if (!function_exists('member_status_badge')) {

        function member_status_badge($status)
        {
           if($status == Member::STATUS_ACTIVE){
            return '<span class="badge badge-success">'.$status.'</span>';
           }else  if($status == Member::STATUS_INACTIVE){
            return '<span class="badge badge-primary">'.$status.'</span>';
           } else {
            return '<span class="badge badge-danger">'.$status.'</span>';
           }
        }
    }
}


if (!function_exists('getSetting')) {

    function getSetting($value = '')
    {
       return \Robiussani152\Settings\Facades\Settings::get($value);
    }
}

if (!function_exists('setSetting')) {

    function setSetting($key = '',$value = '')
    {
       return \Robiussani152\Settings\Facades\Settings::set($key, $value);
    }
}
