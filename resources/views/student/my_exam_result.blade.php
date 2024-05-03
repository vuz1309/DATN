  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Điểm của bạn</h1>
                      </div>

                  </div>
              </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="row">

                      @foreach ($getRecord as $value)
                          <!-- /.col -->
                          <div class="col-md-12">
                              <div class="card">

                                  <div class="card-header">{{ $value['exam_name'] }}</div>
                                  <!-- /.card-header -->
                                  <div class="card-body p-0">
                                      <table class="table table-striped">
                                          <thead>
                                              <tr>

                                                  <th>Môn học</th>
                                                  <th>Điểm trên lớp</th>
                                                  <th>Điểm về nhà</th>
                                                  <th>Điểm kiểm tra</th>
                                                  <th>Điểm bài thi</th>
                                                  <th>Điểm đạt</th>
                                                  <th>Tổng điểm</th>
                                                  <th>Tổng kết</th>

                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($value['subject'] as $exam)
                                                  <tr>
                                                      <td>{{ $exam['subject_name'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['class_work'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['home_work'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['test_work'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['exam'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['passing_mark'] }} /
                                                          {{ $exam['full_marks'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['total'] }}</td>
                                                      <td style="text-align: center;">{{ $exam['grade'] }}</td>

                                                  </tr>
                                              @endforeach
                                          </tbody>
                                      </table>

                                  </div>
                                  <div class="card-footer">
                                      <div class="col-sm-6 right">
                                          <a target="_" class="btn btn-primary"
                                              href="{{ url('student/my_exam_result_print/' . $value['exam_id']) }}">In
                                              kết quả</a>
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                              <!-- /.card -->
                          </div>
                          <!-- /.col -->
                      @endforeach
                  </div>
                  <!-- /.row -->

                  <!-- /.row -->
              </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
      </div>
  @endsection
