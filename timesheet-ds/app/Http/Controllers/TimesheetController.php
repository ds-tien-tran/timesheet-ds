<?php

namespace App\Http\Controllers;

use App\Exports\TimesheetsExport;
use App\Http\Requests\CreateTimesheetRequest;
use App\Http\Requests\EditTimesheetRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\TimesheetServiceInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetController extends Controller
{
    public function __construct(
        protected TimesheetServiceInterface $timesheetService, 
        protected UserRepositoryInterface $userRepository
    )
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
     * Get all data timesheet by user
     */
    public function getAllByUser($id)
    {
        $timesheets = $this->timesheetService->getAllByUser($id);

        return response()->json($timesheets);
    }

    /**
     * Show detail timesheet
     */
    public function show($id)
    {
        $timesheet = $this->timesheetService->getById(Auth::user(), $id);
        if (!$this->authorize('show', $timesheet))
        {
            return abort(403);
        }
        
        return view('timesheet.edit', compact('timesheet')) ;
    }

    /**
     * Update timesheet
     */
    public function update($id, EditTimesheetRequest $request)
    {
        $timesheet = $this->timesheetService->getById(Auth::user(), $id);
        if (!$this->authorize('update', $timesheet))
        {
            return abort(403);
        }

        try {
           $this->timesheetService->update($timesheet, $id, $request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Edit timesheet fail!');
        }

        return redirect()->back()->with('success', 'Edit timesheet success');
    }

    /**
     * List timesheet by user
     */
    public function listTimesheet($userId, Request $request)
    {
        $timesheets = $this->timesheetService->getAllByUserRoleAdmin($userId, $request);
        $user = $this->userRepository->getUserById($userId);

        return view('timesheet.list_report', compact('timesheets', 'user'));
    }

    /**
     * Show detail timesheet  role admin,manager
     */
    public function showDetail($timesheetId)
    {
        $timesheet = $this->timesheetService->getById(Auth::user(), $timesheetId);

        return view('timesheet.detail', compact('timesheet'));
    }

    /**
     * Change status timesheet
     */
    public function changeStatus($timesheetId, Request $request)
    {
        try {
            $this->timesheetService->changeStatus(Auth::user(), $timesheetId, $request->all());
        } catch (Exception $e)
        {
            return redirect()->back()->with('error', 'Change status timesheet fail!');
        }

        return redirect()->back()->with('success', 'Change status timesheet success');
    }

    /**
     * Export timesheet
     */
    public function exportTimesheet($id, Request $request)
    {
        return Excel::download(new TimesheetsExport($id, $request->all()), Carbon::now()->format('YmdHis').'Timesheet.xlsx');
    }
}
