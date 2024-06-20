  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách bài thi</h1>
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
                          @include('_message')
                          <!-- /.card -->

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">
                                  <div class="card-header">Tìm kiếm</div>

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-3">
                                              <label for="exam_id">Bài thi</label>
                                              <select class="form-control getExam" name="exam_id">
                                                  <option value="">Chọn bài thi</option>
                                                  @if (!empty($getExam))
                                                      @foreach ($getExam as $exam)
                                                          <option
                                                              {{ Request::get('exam_id') == $exam->id ? 'selected' : '' }}
                                                              value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                      @endforeach
                                                  @endif
                                              </select>
                                          </div>

                                          <div class="form-group col-md-3">
                                              <label for="class_id">Lớp học</label>
                                              <select class="form-control getClass" name="class_id">
                                                  <option value="">Chọn lớp</option>

                                                  @if (!empty($getClass))
                                                      @foreach ($getClass as $class)
                                                          <option
                                                              {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                              value="{{ $class->id }}">{{ $class->name }}</option>
                                                      @endforeach
                                                  @endif
                                              </select>

                                          </div>


                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('vAdmin/examinations/exam_schedule') }}"
                                                  class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>
                                  </div>
                              </form>
                          </div>
                          @if (!empty(Request::get('exam_id')) && !empty(Request::get('class_id')))
                              <form action="{{ url('vAdmin/examinaions/schedule/add') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input hidden type="text" name="class_id" value="{{ Request::get('class_id') }}" />
                                  <input hidden type="text" name="exam_id" value="{{ Request::get('exam_id') }}" />
                                  <div class="card">

                                      <div class="card-header">
                                          <h3>Lịch thi</h3>
                                      </div>
                                      <div style="overflow-x: auto;" class="card-body p-0">
                                          @if (empty($noUseTools))
                                              <div id="tools"></div>
                                          @endif
                                          <table id="tableList" class="table table-striped">
                                              <thead>
                                                  <tr>
                                                      <th>Khóa học</th>
                                                      <th>Ngày thi</th>
                                                      <th>Bắt đầu</th>
                                                      <th>Kết thúc</th>
                                                      <th>Phòng</th>
                                                      <th>Điểm tối đa</th>
                                                      <th>Điểm đạt</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @php
                                                      $i = 1;
                                                  @endphp
                                                  @foreach ($getRecord as $schedule)
                                                      <tr>


                                                          <td>{{ $schedule['subject_name'] }}
                                                              <input name="schedule[{{ $i }}][subject_id]"
                                                                  type="hidden" value="{{ $schedule['subject_id'] }}" />
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['exam_date'] }}"
                                                                  name="schedule[{{ $i }}][exam_date]"
                                                                  type="date" class="form-control">
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['start_time'] }}"
                                                                  name="schedule[{{ $i }}][start_time]"type="time"
                                                                  class="form-control">
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['end_time'] }}"
                                                                  name="schedule[{{ $i }}][end_time]"
                                                                  type="time" class="form-control">
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['room_number'] }}"
                                                                  name="schedule[{{ $i }}][room_number]"
                                                                  type="text" class="form-control">
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['full_marks'] }}"
                                                                  name="schedule[{{ $i }}][full_marks]"
                                                                  type="text" class="form-control">
                                                          </td>
                                                          <td>
                                                              <input value="{{ $schedule['passing_mark'] }}"
                                                                  name="schedule[{{ $i }}][passing_mark]"
                                                                  type="text" class="form-control">
                                                          </td>
                                                      </tr>
                                                      @php
                                                          $i++;
                                                      @endphp
                                                  @endforeach

                                              </tbody>
                                          </table>
                                          <div style="text-align: center; padding: 10px;"><button class="btn btn-primary">
                                                  Lưu </button></div>

                                      </div>
                                      <!-- /.card-body -->
                              </form>
                      </div>
                      @endif
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

  {{-- @section('script')
      <script type="text/javascript">
          $('.getExam').change(function() {
              var exam_id = $(this).val();
              $.ajax({
                  url: "{{ url('vAdmin/exam/get_class') }}",
                  type: "POST",
                  data: {
                      "_token": "{{ csrf_token() }}",
                      exam_id: exam_id,
                  },
                  dataType: "json",
                  success: function(response) {
                      $('.getClass').html(response.html);
                  }
              })
          })
      </script>
  @endsection --}}
