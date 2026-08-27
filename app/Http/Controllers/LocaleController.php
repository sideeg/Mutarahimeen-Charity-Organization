<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['ar', 'en'])) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}