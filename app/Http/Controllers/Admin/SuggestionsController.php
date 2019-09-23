<?php

namespace App\Http\Controllers\Admin;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class SuggestionsController extends Controller
{
    public function index()
    {
		$rows = Suggestion::get();
		return view('dashboard.suggestions.index', compact('rows'));
    }

    public function delete(Request $request)
    {
        Suggestion::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف الشكوي', $request->ip());
        Session::flash('success', 'تم حذف الشكوي بنجاح');
        return back();
    }

    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Suggestion::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من الشكاوي', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
