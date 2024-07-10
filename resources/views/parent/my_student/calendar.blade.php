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
                      <h1>Lịch học <span style="color: blue;">{{ $getStudent->name }} {{ $getStudent->last_name }}</span>
                      </h1>
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

      // @foreach ($getMyTimeable as $value)
      //     @foreach ($value['week'] as $week)

      //         events.push({
      //             title: '{{ $value['name'] }}',
      //             daysOfWeek: [{{ $week['fullcalendar_day'] }}],
      //             startTime: '{{ $week['start_time'] }}',
      //             endTime: '{{ $week['end_time'] }}',
      //             start: '{{ $week['start_date'] }}',
      //             end: '{{ $week['end_date'] }}',
      //         });
      //     @endforeach
      // @endforeach

      @foreach ($getMyTimeable as $value)
          @foreach ($value['week'] as $week)
              var currentDate = new Date('{{ $week['start_date'] }}');
              var endDate = new Date('{{ $week['end_date'] }}');

              while (currentDate <= endDate) {
                  var dayOfWeek = currentDate.getDay();
                  // Kiểm tra nếu ngày hiện tại là một trong những ngày lặp lại của tuần
                  if ({{ $week['fullcalendar_day'] }}.indexOf(dayOfWeek) !== -1) {
                      events.push({
                          title: '{{ $value['name'] }}',
                          startTime: '{{ $week['start_time'] }}',
                          endTime: '{{ $week['end_time'] }}',
                          start: new Date(currentDate.toISOString().split('T')[0] +
                              'T{{ $week['start_time'] }}'),
                          end: new Date(currentDate.toISOString().split('T')[0] + 'T{{ $week['end_time'] }}'),
                          daysOfWeek: [dayOfWeek]
                      });
                  }
                  // Chuyển sang ngày tiếp theo
                  currentDate.setDate(currentDate.getDate() + 1);
              }
          @endforeach
      @endforeach

      @foreach ($getExamTimeable as $valueE)
          @foreach ($valueE['exam'] as $exam)
              events.push({
                  title: '{{ $valueE['name'] }} - {{ $exam['subject_name'] }}: {{ date('h:i:A', strtotime($exam['start_time'])) }}-{{ date('h:i:A', strtotime($exam['end_time'])) }}',
                  start: '{{ $exam['exam_date'] }}',
                  end: '{{ $exam['exam_date'] }}',
                  color: 'red',

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
          buttonText: {
              today: 'Hôm nay',
              month: 'Tháng',
              week: 'Tuần',
              day: 'Ngày',
              list: 'Danh sách',
              prev: 'Trước',
              next: 'Sau'
          },
          initialDate: new Date(),
          navLinks: true,
          editable: false,
          timeZone: 'local',
          events: events,
          initialView: 'dayGridMonth',
          locale: 'vi'

      });

      calendar.render();
  </script>
@endsection
