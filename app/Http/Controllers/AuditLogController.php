<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')->latest('timestamp')->paginate(30);
        return view('auditlog.index', compact('logs'));
    }
}