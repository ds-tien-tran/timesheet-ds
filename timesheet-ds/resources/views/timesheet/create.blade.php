@extends('layouts.main')
@section('content')
<h4>Create timesheet</h4>
<div class="card p-4">
    @include('notification.error')
    @include('notification.success')
    <form method="POST" action="{{route('timesheet.store')}}" id="formTask">
        @csrf
        <div class="mb-3">
            <label class="form-label">Select Date</label>
            <input type="date" class="form-control w-300" name="day_selected" value="{{ date('Y-m-d') }}">
            @error('day_selected')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Note</label>
            <textarea class="form-control" rows="3" name="note"></textarea>
          </div>
        <div class="mb-3">
            <label class="form-label">Plan next day</label>
            <input type="text" class="form-control" name="plan">
        </div>
        <div class="mb-3">
            <button class="btn btn-success" id="addTask" type="button"><i class="fas fa-solid fa-plus"></i> ADD TASK</button>
        </div>
        <div class="row mt-3 mb-3 border-bottom">
            <div class="col-md-2"><span>TASKID</span></div>
            <div class="col-md-2"><span>CONTENT</span></div>
            <div class="col-md-2"><span>TIMEUSE</span></div>
            <div class="col-md-2"><span>STATUS</span></div>
            <div class="col-md-2"><span>ACTION</span></div>
        </div>
        <div class="content-task">
            <div class="row mt-3" id="text-first">
                <div class="col text-center"> <b>Add more task</b></div>
            </div>
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" id='btnCreate'>Create</button>
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
        .btnDel:hover{
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var postion = 0;
            $('#addTask').on("click", function () {
                postion++;
                $('#text-first').hide();
                $('.content-task').append(
                    `
                    <div class="row pb-3 mt-3 mb-3 border-bottom">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="tasks[${postion}][task_id]">
                        </div>
                        <div class="col-md-2">
                            <textarea class="form-control" name="tasks[${postion}][content]"></textarea>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="tasks[${postion}][time_use]">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" aria-label="Default select example" name="tasks[${postion}][status]">
                                <option value="1">Open</option>
                                <option value="2">Processing</option>
                                <option value="3">End</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <i class="fas fa-solid fa-trash text-danger btnDel"></i>
                        </div>
                    </div>
                    `
                );
            });

            $(document).on('click','.btnDel', function () {
                $(this).parent().parent().remove();
            })

            $(document).on('click','#btnCreate', function()
            {
               let checkTask = $('input[name^="tasks"]');
               checkTask.each(function() {
                let input = $(this).val();
                if (input == '') {
                    alert('Can not empty field create task');
                    return false;
                }
               });
               $('#formTask').submit()
            });
        });
    </script>
@endpush