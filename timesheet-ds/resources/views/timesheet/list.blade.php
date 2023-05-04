@extends('layouts.main')
@section('content')
    <div id='calendar'></div>
@endsection
@push('css')
    <style>
       .fc-event{
            cursor: pointer;
        }
    </style>
@endpush
@push('scripts')
   
    <script type="text/javascript">
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: function(start, end, timezone, callback) { 
                $.ajax({
                    type: "GET",
                    url: "{{route('timesheet.getAll',['id' => Auth::user()->id])}}",
                    dataType: "json",
                    success: function (doc) {
                        var events = [];   //javascript event object created here
                        var obj = doc;
                        console.log(obj);
                        $(obj).each(function () {                          
                                events.push({
                                    title:'timesheet_' + $(this).attr('day_selected'),  //your calevent object has identical parameters 'title', 'start', ect, so this will work
                                    start: $(this).attr('day_selected'), // will be parsed into DateTime object    
                                    end: $(this).attr('day_selected'),
                                    id: $(this).attr('id')
                                });
                            });                     
                        if (callback) callback(events);
                    }
                });
            },
            eventClick: function(info) {
                if (info.id) {
                    var id = info.id;
                    window.location.replace('show/'+ id);
                }
            }
        });
    });
       
    </script>
@endpush
