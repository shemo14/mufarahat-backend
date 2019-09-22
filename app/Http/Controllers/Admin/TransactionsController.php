<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TransactionsController extends Controller
{
    public function index(){
		$rows = Transaction::where('status',0)->get();
		return view('dashboard.transactions.index', compact('rows'));
    }
    
    public function markedAsPay(Request  $request)
    {
        $delegate = Transaction::findOrFail($request->active_id);
        $delegate->status   =  1 ;
        $delegate->save();
        $ip = $request->ip();
        addReport(auth()->user()->id,'قام بتأكيد استلام ', $ip);
        Session::flash('success', 'تم تأكيد الاستلام بنجاح ');
        return back();

    }
}
