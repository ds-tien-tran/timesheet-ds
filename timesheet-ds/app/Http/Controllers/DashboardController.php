<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\TimesheetServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected TimesheetServiceInterface $timesheetService)
    {
        
    }

    /**
     * Get view dashboard
     */
    public function index()
    {
        //take value đã điểm danh hằng ngày
        $data = $this->timesheetService->getTimesheetRegister(Auth::user()->id);

        return view('dashboard', compact('data'));
    }
}
