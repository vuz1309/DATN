  @extends('layouts.app')

  @section('content')
  @section('style')
      <style type="text/css">
          .fc-daygrid-event {
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
  <script src="{{ url('public/dist/fullCalendar/index.global.min.js') }}"></script>


  <script type="text/javascript">
      var events = new Array();

      @foreach ($getMyTimeable as $value)
          @foreach ($value['week'] as $week)
              events.push({
                  title: '{{ $value['name'] }}',
                  daysOfWeek: [{{ $week['fullcalendar_day'] }}],
                  startTime: '{{ $week['start_time'] }}',
                  endTime: '{{ $week['end_time'] }}',
              });
          @endforeach
      @endforeach

      @foreach ($getExamTimeable as $valueE)
          @foreach ($valueE['exam'] as $exam)
              events.push({
                  title: '{{ $valueE['name'] }} - {{ $exam['subject_name'] }}: {{ date('h:i:A', strtotime($exam['start_time'])) }}-{{ date('h:i:A', strtotime($exam['end_time'])) }}',
                  start: '{{ $exam['exam_date'] }}',
                  end: '{{ $exam['exam_date'] }}',
                  color: 'red',
                  url: '{{ url('vStudent/my_calendar') }}'
              });
          @endforeach
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
