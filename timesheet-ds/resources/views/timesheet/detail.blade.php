@extends('layouts.main')
@section('content')
<h4>Detail timesheet</h4>
<div class="card p-4">
    @include('notification.error')
    @include('notification.success')
    <div class="mb-3">
        <label class="form-label">Select Date</label>
        <input type="date" class="form-control w-300" name="day_selected" value="{{ $timesheet->day_selected }}" readonly>
        @error('day_selected')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Note</label>
        <textarea class="form-control" rows="3" name="note" readonly>{{ $timesheet->note }}</textarea>
        </div>
    <div class="mb-3">
        <label class="form-label">Plan next day</label>
        <input type="text" class="form-control" name="plan" readonly value="{{ $timesheet->plan }}">
    </div>
    <h4>List task</h4>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">TASKID</th>
            <th scope="col">CONTENT</th>
            <th scope="col">TIMEUSE</th>
            <th scope="col">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timesheet->tasks as $item)
                <tr>
                    <td>{{ $item->task_id }}</td>
                    <td>{{ $item->content }}</td>
                    <td>{{ $item->time_use }}</td>
                    <td>{{ config('define.task_status.'.$item->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mb-3">
        <span>Status timesheet: {{ config('define.timesheet_status.'.$timesheet->status) }}</span>
    </div>
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusTimesheet">Change status</button>
        <a href="{{ route('user.list')}}" class="btn btn-warning">Back</a>
    </div>
    <!-- Modal -->
    <form method="POST" action="{{route('timesheet.changeStatus', $timesheet->id)}}" id="formTask">
        @csrf
        @method('PATCH')
        <div class="modal fade" id="statusTimesheet" tabindex="-1" aria-labelledby="statusTimesheetLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-open" checked value="1">
                            <label class="form-check-label" for="status-open">
                            Open
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-approve" value="2">
                            <label class="form-check-label" for="status-approve">
                            Approve
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-reject" value="3">
                            <label class="form-check-label" for="status-reject">
                            Reject
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('css')
    <style>
        .w-300{
            width: 300px;
        }
        .border-bottom{
            border-bottom: 2px solid black;
        }
    </style>
@endpush
