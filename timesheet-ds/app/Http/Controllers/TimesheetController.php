<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTimesheetRequest;
use App\Http\Requests\EditTimesheetRequest;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\TimesheetServiceInterface;
use Exception;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function __construct(protected TimesheetServiceInterface $timesheetService)
    {
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

    /**
     * Get list view timesheet
     */
    public function list()
    {
        return view('timesheet.list');
    }

    /**
     * Get all data timesheet
     */
    public function getDataAllTimesheet()
    {
        $timesheets = $this->timesheetService->getAll();

        return response()->json($timesheets);
    }

    /**
     * Show detail timesheet
     */
    public function show($id)
    {
        $timesheet  = $this->timesheetService->getById($id);

        return view('timesheet.edit', compact('timesheet')) ;
    }

    /**
     * Update timesheet
     */
    public function update($id, EditTimesheetRequest $request)
    {
        try {
            $this->timesheetService->update($id, $request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Edit timesheet fail!');
        }

        return redirect()->back()->with('success', 'Edit timesheet success');
    }

}
