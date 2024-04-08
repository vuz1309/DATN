  
@extends('layouts.app')
   
@section('content')
@section('style')
<style type="text/css">
    .fc-daygrid-event{
        white-space: normal;
    }
</style>
@endsection

<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Lịch học</h1>
       </div>
     </div>
   </div><!-- /.container-fluid -->
 </section>

 <!-- Main content -->
 <section class="content">
   <div class="container-fluid">
     <div class="row">
        
       <!-- /.col -->
       <div class="col-md-12">
         <div id="calendar">

         </div>

       </div>
       <!-- /.col -->
     </div>
     <!-- /.row -->
     
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </section>
 <!-- /.content -->
</div>

@endsection

@section('script')
<script src="{{url('public/dist/fullCalendar/index.global.min.js')}}"></script>


<script type="text/javascript">
    var events = new Array();
    @foreach ($getClassTimeable as $value )
       
            events.push({
                title: '{{ $value->class_name }} - {{ $value->subject_name }} ',
                daysOfWeek: [ {{ $value->fullcalendar_day }} ],
                startTime: '{{ $value->start_time }}',
                endTime: '{{ $value->end_time }}',
            });
       
    @endforeach
    @foreach ($getExamTimeable as $value )
       
            events.push({
                title: '{{ $value->class_name }} - {{ $value->exam_name }} - {{ $value->subject_name }}: {{ date('h:i:A', strtotime($value->start_time)) }}-{{  date('h:i:A', strtotime($value->end_time)) }} ',
                start: '{{ $value->exam_date }}',
                end: '{{ $value->exam_date }}',
                color: 'red',
                url: '{{url('teacher/calendar')}}'
            });
       
    @endforeach
    var calendarId = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarId, {
       
        headerToolbar: {
            left: 'prev,next,today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, timeGridDay, listMonth'
        },
        initialDate: new Date(),
        navLinks: true,
        editable: false,
        timeZone: 'local',
        events: events,
        initialView: 'dayGridMonth'
        
    });

    calendar.render();
</script>
@endsection

