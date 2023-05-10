<?php

namespace App\Exports;

use App\Models\Timesheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TimesheetsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $id;
    protected $request;

    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $monthSelect = $this->request['month_select'];
        $firstDate = date($monthSelect.'-01 00:00:00');
        $endDate = date($monthSelect.'-t 23:59:59');

        return Timesheet::where('user_id', $this->id)
                ->where('day_selected', '>=', $firstDate)
                ->where('day_selected', '<=', $endDate)
                ->with('user')
                ->get();
    }

    /**
    * @return array
    */
    public function headings() :array
    {
        return ["Name","Day_selected", "Plan", "Note", "Status", "Dayoff", "Created_at"];
    }
    /**
    * @var Timesheet $timesheet
    */
    public function map($timesheet): array
    {
        return [
            $timesheet->user->name,
            $timesheet->day_selected,
            $timesheet->plan,
            $timesheet->note,
            config('define.timesheet_status.'.$timesheet->status),
            $timesheet->dayoff == 0 ? 'work' : 'off',
            Carbon::parse($timesheet->created_at)->format('H:i:s'),
        ];
    }
}
