<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{
    public function index(){
        return view('contact_us');
    }
    public function store(ContactUs $contactUs, Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);

        try {
            $contactUs->create($validated);
            return redirect()->back()->with('success', 'پیام با موفقیت ارسال شد.');
        } catch(Exception $e){
            Log::error("Error send messag". $e->getMessage());
            return redirect()->back()->with('error', 'ارسال پیام خطا مواجه شد. لطفاً دوباره تلاش کنید.'. (env('APP_ENV' ) === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}
