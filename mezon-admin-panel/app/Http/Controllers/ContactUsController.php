<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     * تمام پیام ها را از جدول اسلایدر ها دریافت می کند به و در متغیر مخاطبین به ویو ارسال می کند 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contacts = ContactUs::get();
        return view('contact.index', compact('contacts'));
    }

    /**
     * Display the specified resource.
     * پیام های کاربران را از مدل می گیرد و به ویو ارسال می کند
     * @param \App\Models\ContactUs $contactUs مدل ارتباط با ما برای حذف داده را دریافت می کند
     * @return \Illuminate\View\View
     */
    public function show(ContactUs $contactUs)
    {
        return view('contact.show', compact('contactUs'));

    }

    /**
     * Remove the specified resource from storage.
     *  Remove the specified resource from storage.
     * پیام مشخص شده توسط کاربر را حذف می کند
     * @param \App\Models\ContactUs $contactUs مدل ارتباط با ما برای حذف داده را دریافت می کند
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactUs $contactUs)
    {
        try {
            $contactUs->delete();
            return redirect()->route('contact-us.index')->with('success', ' پیام با موفقیت حذف شد.');
        } catch( Exception $e){
            Log::error("Error deleting message: ". $e->getMessage());
            return redirect()->route('contact-us.index')->with('error', 'حذف پیام با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}
