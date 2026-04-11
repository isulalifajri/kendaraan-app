<?php

namespace App\Http\Controllers;

class AuditController extends Controller
{
    public function index()
    {
        $title = 'Log Activity';
        $logs = \OwenIt\Auditing\Models\Audit::with('user')
                    ->latest()
                    ->paginate(10);

        return view('audit.index', compact('title','logs'));
    }
}
