  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thời khóa biểu ( <span style="color: blue">
                                  {{ $getStudent->name . ' ' . $getStudent->last_name }}</span> )</h1>
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


                          <div class="card">

                              <div class="card-header">
                                  <h3>Môn: {{ $getSubject->name }} - Lớp: {{ $getClass->name }}</h3>
                              </div>
                              <div class="card-body p-0">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif
                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th>Tuần</th>
                                              <th>Bắt đầu</th>
                                              <th>Kết thúc</th>
                                              <th>Phòng</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                          @php
                                              $i = 1;
                                          @endphp

                                          @foreach ($week as $value)
                                              <tr>
                                                  <td>

                                                      <span style="font-weight: bold;">{{ $value['week_name'] }}</span>
                                                  </td>
                                                  <td>
                                                      <input readonly style="max-width: 200px;" type="time"
                                                          value="{{ $value['start_time'] }}"
                                                          name="timeable[{{ $i }}][start_time]"
                                                          class="form-control" />
                                                  </td>
                                                  <td>
                                                      <input readonly style="max-width: 200px;" type="time"
                                                          value="{{ $value['end_time'] }}"
                                                          name="timeable[{{ $i }}][end_time]"
                                                          class="form-control" />
                                                  </td>
                                                  <td>
                                                      <input readonly style="max-width: 200px;" style="width: 200px;"
                                                          value="{{ $value['room_number'] }}" type="text"
                                                          name="timeable[{{ $i }}][room_number]"
                                                          class="form-control" />
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
                          <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- /.row -->
                  </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
      </div>
  @endsection
