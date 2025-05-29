<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Signature;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class LayoutController extends Controller
{
    public function layouts_memberlist()
    {
        set_page_meta('Layouts');
        $users = Member::where('status', '=', 'active')->get();
        return view('pages.admin.member-management.layouts.index', compact('users'));
    }
    public function process_data(Request $request)
    {
        $request->validate([
            'users' => 'array|required|min:1',
            'type' => 'string|required'
        ]);

        $data =  Member::with('associatorsInfo')->whereIn('id', $request->users)->get();

        if ($request->type == 'certificate') {
            $path = 'layouts.admin.layout.certificate';
        } elseif ($request->type == 'id-card') {
            $path = 'layouts.admin.layout.id-card';
        }
        $signs = Signature::all();

        // $qrCode = base64_encode(QrCode::format('png')->generate('asasd'));

        $pdf = Pdf::setOption([
            'dpi' => 150,
            'defaultFont' => 'serif',
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isJavascriptEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'show-pagination' => true,
        ])->loadView($path, compact('data', 'signs'));

        if ($request->type == 'certificate') {
            return $pdf->download('certificate.pdf');
        } elseif ($request->type == 'id-card') {
            return $pdf->download('id-card.pdf');
        }
    }

    public function certificate()
    {
        set_page_meta('Layouts');
        return view('layouts.admin.layout.id-card');
    }

    public function add_signature()
    {
        set_page_meta('Signature');
        return view('pages.admin.member-management.layouts.signature');
    }

    public function upload_signature(Request $request)
    {
        $request->validate([
            'signature_title' => 'required|string|max:255',
            'signature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            'cropped_image' => 'required|image', // Ensure cropped image data is present
        ]);

        try {
            // Store the original image
            // $originalImage = $request->file('signature_image')->store('signatures', 'public');
            $croppedImage = $request->file('cropped_image');
            // Store the cropped image
            $croppedImagePath = $croppedImage->store('signatures', 'public');
            DB::beginTransaction();
            Signature::create([
                'title' => strtolower(trim($request->input('signature_title'))),
                'file_location' => $croppedImagePath,
            ]);
            DB::commit();
            return response()->json(['success' => false, 'message' => 'Signature uploaded successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Signature upload failed']);
        }
        // Return a response, redirect, or perform any other desired action
    }
}
