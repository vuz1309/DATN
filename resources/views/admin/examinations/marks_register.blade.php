  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Điểm</h1>
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
                                              <label for="exam_id">Kì thi</label>
                                              <select class="form-control getExam" name="exam_id">
                                                  <option value="">Chọn kì thi</option>
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
                                                  <option value="">Chọn lớp học</option>
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
                                              <a href="{{ url('vAdmin/examinations/marks_register') }}"
                                                  class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>
                                  </div>
                              </form>
                          </div>

                          @if (!empty($getSubject) && !empty($getSubject->count()))
                              <div class="card">

                                  <div class="card-header">
                                  </div>
                                  <div style="overflow-x: auto;" class="card-body p-0">
                                      <div id="searchBox" style="padding-left: 16px; padding-top: 8px"></div>
                                      @if (empty($noUseTools))
                                          <div id="tools"></div>
                                      @endif
                                      <table id="tableList" class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th>Học sinh</th>
                                                  @foreach ($getSubject as $subject)
                                                      <th>{{ $subject->subject_name }} <br />
                                                          ({{ $subject->subject_type }} {{ $subject->passing_mark }} /
                                                          {{ $subject->full_marks }})
                                                      </th>
                                                  @endforeach
                                                  <th></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @if (!empty($getStudent) && !empty($getStudent->count()))
                                                  @foreach ($getStudent as $student)
                                                      <form name="post" class="SubmitForm">
                                                          {{ csrf_field() }}
                                                          <tr>
                                                              <input type="hidden" name="student_id"
                                                                  value="{{ $student->id }}" />
                                                              <input type="hidden" name="exam_id"
                                                                  value="{{ Request::get('exam_id') }}" />
                                                              <input type="hidden" name="class_id"
                                                                  value="{{ Request::get('class_id') }}" />
                                                              <td>
                                                                  {{ $student->name }} {{ $student->last_name }}
                                                              </td>
                                                              @php
                                                                  $id = 1;
                                                                  $totalStudentMark = 0;
                                                                  $totalSubject = 0;
                                                                  $totalPass = 0;
                                                                  $totalFail = 0;
                                                              @endphp
                                                              @foreach ($getSubject as $subject)
                                                                  @php
                                                                      $totalMark = 0;
                                                                      $totalSubject += $subject->full_marks;
                                                                      $getMark = $subject->getmark(
                                                                          $student->id,
                                                                          Request::get('exam_id'),
                                                                          Request::get('class_id'),
                                                                          $subject->subject_id,
                                                                      );
                                                                      if (!empty($getMark)) {
                                                                          $totalMark =
                                                                              $getMark->class_work +
                                                                              $getMark->home_work +
                                                                              $getMark->test_work +
                                                                              $getMark->exam;
                                                                          $totalStudentMark += $totalMark;
                                                                      }

                                                                      $percent =
                                                                          ($totalMark / $subject->full_marks) * 10;
                                                                      $getGrade = App\Models\MarksGradeModel::getGrade(
                                                                          $percent,
                                                                      );
                                                                  @endphp
                                                                  <td> <input style="width: 200px;" type="hidden"
                                                                          value="{{ $subject->id }}"
                                                                          name="mark[{{ $id }}][id]"
                                                                          class="form-control" />
                                                                      <input style="width: 200px;" type="hidden"
                                                                          value="{{ $subject->subject_id }}"
                                                                          name="mark[{{ $id }}][subject_id]"
                                                                          class="form-control" />
                                                                      {{-- <div style="margin-bottom: 10px;"> --}}
                                                                      {{-- Điểm trên lớp --}}

                                                                      {{-- <input
                                                                              id="class_work_{{ $student->id }}{{ $subject->subject_id }}"
                                                                              value="{{ !empty($getMark) ? $getMark->class_work : '' }}"
                                                                              style="width: 200px;" type="text"
                                                                              name="mark[{{ $id }}][class_work]"
                                                                              class="form-control" /> --}}
                                                                      {{-- </div> --}}
                                                                      {{-- <div style="margin-bottom: 10px;">
                                                                          Điểm về nhà
                                                                          <input
                                                                              id="home_work_{{ $student->id }}{{ $subject->subject_id }}"
                                                                              value="{{ !empty($getMark) ? $getMark->home_work : '' }}"
                                                                              style="width: 200px;" type="text"
                                                                              name="mark[{{ $id }}][home_work]"
                                                                              class="form-control" />
                                                                      </div> --}}
                                                                      {{-- <div style="margin-bottom: 10px;">
                                                                          Điểm kiểm tra
                                                                          <input
                                                                              id="test_work_{{ $student->id }}{{ $subject->subject_id }}"
                                                                              value="{{ !empty($getMark) ? $getMark->test_work : '' }}"
                                                                              style="width: 200px;" type="text"
                                                                              name="mark[{{ $id }}][test_work]"
                                                                              class="form-control" />
                                                                      </div> --}}
                                                                      <div style="margin-bottom: 10px;">
                                                                          Điểm thi
                                                                          <input
                                                                              id="exam_{{ $student->id }}{{ $subject->subject_id }}"
                                                                              value="{{ !empty($getMark) ? $getMark->exam : '' }}"
                                                                              style="width: 200px;" type="text"
                                                                              name="mark[{{ $id }}][exam]"
                                                                              class="form-control" />
                                                                      </div>
                                                                      <div style="margin-bottom: 10px;">
                                                                          <button class="btn btn-primary SaveSingleSubject"
                                                                              id="{{ $student->id }}"
                                                                              data-schedule="{{ $subject->id }}"
                                                                              data-val="{{ $subject->subject_id }}"
                                                                              data-exam="{{ Request::get('exam_id') }}"
                                                                              data-class="{{ Request::get('class_id') }}">Lưu</button>

                                                                      </div>
                                                                      <div style="margin-bottom: 10px;">
                                                                          <b>Tổng điểm: {{ $totalMark }}</b>
                                                                          <br />
                                                                          <b>Điểm đạt:
                                                                              {{ $subject->passing_mark }} </b>
                                                                          <br />

                                                                          @if ($totalMark > 0)
                                                                              <b>Tổng kết: <span style="color: red">
                                                                                      {{ $getGrade }}</span>
                                                                              </b>
                                                                              <br />
                                                                          @endif



                                                                          @if ($subject->passing_mark <= $totalMark)
                                                                              <b style="color: green">Đạt</b>
                                                                              @php
                                                                                  $totalPass += 1;
                                                                              @endphp
                                                                          @else
                                                                              <b style="color: red">Trượt</b>
                                                                              @php
                                                                                  $totalFail += 1;
                                                                              @endphp
                                                                          @endif
                                                                      </div>
                                                                  </td>
                                                                  @php
                                                                      $id++;
                                                                  @endphp
                                                              @endforeach
                                                              <td>
                                                                  {{-- <button class="btn btn-success">Lưu</button> --}}
                                                                  <div>
                                                                      <b style="color: green">Đạt: </b>
                                                                      {{ $totalPass }}
                                                                      <br />
                                                                      <b style="color: red">Trượt: </b>
                                                                      {{ $totalFail }}
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                      </form>
                                                  @endforeach
                                              @endif
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                      </div>
                      @endif
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
      <script type="text/javascript">
          $('.SubmitForm').submit(function(e) {
              e.preventDefault();

              $.ajax({
                  type: "POST",
                  url: "{{ url('vAdmin/examinations/submit_marks_register') }}",
                  data: $(this).serialize(),
                  dataType: 'json',
                  success: function(data) {
                      showAlert('Thông báo', data.message);
                  },

              })
          });

          $('.SaveSingleSubject').click(function(e) {

              e.preventDefault();
              const student_id = $(this).attr('id');
              const subject_id = $(this).attr('data-val');
              const exam_id = $(this).attr('data-exam');
              const class_id = $(this).attr('data-class');
              const exam_schedule_id = $(this).attr('data-schedule');

              const class_work = 0;
              const home_work = 0;
              const test_work = 0;
              const exam = $('#exam_' + student_id + subject_id).val();

              $.ajax({
                  type: "POST",
                  url: "{{ url('vAdmin/examinations/single_submit_marks_register') }}",
                  data: {
                      '_token': "{{ csrf_token() }}",
                      student_id,
                      id: exam_schedule_id,
                      subject_id,
                      exam_id,
                      class_id,
                      class_work,
                      home_work,
                      test_work,
                      exam
                  },
                  dataType: 'json',
                  success: function(data) {
                      showAlert('Thông báo', data.message);
                      window.location.reload();
                  },

              })
          });
      </script>
  @endsection
