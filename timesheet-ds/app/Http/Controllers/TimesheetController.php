<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTimesheetRequest;
use App\Services\TimesheetService;
use Exception;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    private TimesheetService $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    /**
     * Get view create
     */
    public function create()
    {
       return view('timesheet.create');
    }

    /**
     * Create timesheet
     */
    public function store(CreateTimesheetRequest $request)
    {
        try {
            $this->timesheetService->store($request);
        } catch(Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Create timesheet success');
    }
}
