<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('pages.landing.home');
    }

    public function about()
    {
        return view('pages.landing.about');
    }

    public function order()
    {
        return view('pages.landing.order');
    }

    public function form()
    {
        return view('pages.landing.form');
    }

    public function invoice()
    {
        $invoices = Invoice::where('user_id', auth()->id())->latest()->get();

        return view('pages.landing.invoice', compact('invoices'));
    }

    public function showinvoice(Invoice $invoice)
    {
        $invoice->load('items');

        return view('pages.landing.show-invoice', compact('invoice'));
    }
}
