  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Lịch thi <span
                                  style="color: blue">{{ $getStudent->name . ' ' . $getStudent->last_name }}</span>
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
                          @include('_message')
                          <!-- /.card -->
                          @foreach ($getRecord as $value)
                              <div class="card">
                                  <div class="card-header">
                                      <h3 class="class-title">{{ $value['name'] }}</h3>
                                  </div>
                                  <div style="overflow-x: auto" class="card-body p-0">
                                      @if (empty($noUseTools))
                                          <div id="tools"></div>
                                      @endif
                                      <table id="tableList" class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th>Môn học</th>
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
                                              @foreach ($value['exam'] as $schedule)
                                                  <tr>

                                                      <td>{{ $schedule['subject_name'] }}
                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['exam_date'] }}"
                                                              type="date" class="form-control">

                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['start_time'] }}"
                                                              type="time" class="form-control">
                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['end_time'] }}" type="time"
                                                              class="form-control">
                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['room_number'] }}"
                                                              type="text" class="form-control">
                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['full_marks'] }}"
                                                              type="text" class="form-control">
                                                      </td>
                                                      <td>
                                                          <input readonly value="{{ $schedule['passing_mark'] }}"
                                                              type="text" class="form-control">
                                                      </td>
                                                  </tr>
                                                  @php
                                                      $i++;
                                                  @endphp
                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          @endforeach
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
