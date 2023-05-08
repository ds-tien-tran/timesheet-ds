@extends('layouts.main')
@section('content')
<h1>Report timesheet</h1>
<div class="card shadow mb-4">
    {{-- d-flex align-items-center justify-content-between --}}
    <div class="d-flex d-inline m-4 justify-content-between">
        <form id='formMonth' action="{{ route('timesheet.listTimesheet', $user->id)}}" class="d-flex" method="GET">
            @csrf
            <input class="mr-2 form-control w-200p monthSelect" name="month_select" type="month">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="ml-4">
            <form method="GET" action="{{ route('timesheet.exportTimesheet', $user->id) }}">
                @csrf
                <input class="mr-2 form-control w-200p monthSelect" name="month_select" type="month" hidden>
                {{-- <a href="{{ route('timesheet.exportTimesheet', $user->id) }}" class="btn btn-success" form='formMonth'><i class="fas fa-file-download mr-2"></i>Export timesheet</a> --}}
                @can('seenAdmin')
                    <button type="submit" class="btn btn-success"><i class="fas fa-file-download mr-2"></i>Export timesheet</button>
                @endcan
            </form>
        </div>
    </div>
    
    <h4 class="ml-4"> User : {{ $user->name }} </h4>
    <div class="card-body">
        <table class="table">
            <thead class="table-light">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Day selected</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($timesheets as $key => $timesheet)
                    <tr>
                        <th scope="row">{{ $key + 1}}</th>
                        <td>{{ $timesheet->day_selected }}</td>
                        <td class="{{ config('define.text_color.'. $timesheet->status) }}">{{ config('define.timesheet_status.'. $timesheet->status) }}</td>
                        <td>
                            <a href="{{route('timesheet.showDetail', $timesheet->id)}}" class="btn btn-primary"><i class="fas fa-user-edit"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4"> Not record</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
@push('css')
    <style>
        .w-200p{
            width: 200px;
        }
    </style>
@endpush
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        if(window.location.href.indexOf("month_select") != -1) {
            const month_select = location.search.split('month_select=')[1];
            $('.monthSelect').val(`${month_select.slice(0,4)}-${month_select.slice(-2)}`);
        } else {
            const date = new Date()
            const month = ("0" + (date.getMonth() + 1)).slice(-2)
            const year = date.getFullYear()
            $('.monthSelect').val(`${year}-${month}`);
        }
    })
</script>
@endpush