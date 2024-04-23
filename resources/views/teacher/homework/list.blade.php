  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Bài tập</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('teacher/homework/homework/add') }}">Thêm mới</a>
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
                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">

                                  <div class="card-body">
                                      <div class="row">

                                          <div class="form-group col-md-3">
                                              <label for="class_name">Lớp</label>
                                              <input value="{{ Request::get('class_name') }}" type="text"
                                                  class="form-control" name='class_name' />

                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="subject_name">Môn học</label>
                                              <input value="{{ Request::get('subject_name') }}" type="text"
                                                  class="form-control" name='subject_name' />

                                          </div>

                                          <div class="form-group col-md-3">
                                              <label for="date">Ngày tạo</label>
                                              <input value="{{ Request::get('date') }}" type="date" class="form-control"
                                                  name='date' />
                                          </div>

                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('teacher/homework/homework') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">

                                  <div class="card-body">

                                  </div>

                              </form>
                          </div>


                          <div class="card">

                              <!-- /.card-header -->
                              <div class="card-body p-0" style="overflow: auto;">
                                  <table class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Lớp</th>
                                              <th>Môn học</th>
                                              <th>Bắt đầu</th>
                                              <th>Hạn cuối</th>
                                              <th>Tài liệu</th>
                                              <th>Mô tả</th>
                                              <th>Ngày tạo</th>
                                              <th style="min-width: 160px"></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($getRecord as $value)
                                              <tr>
                                                  <td>{{ $value->id }}</td>
                                                  <td>{{ $value->class_name }}</td>
                                                  <td>{{ $value->subject_name }}</td>
                                                  <td>{{ date('H:i d/m/Y', strtotime($value->homework_date)) }}</td>
                                                  <td>{{ date('H:i d/m/Y', strtotime($value->submission_date)) }}</td>

                                                  <td>
                                                      @if (!empty($value->getDocument()))
                                                          <a download="" href="{{ $value->getDocument() }}"
                                                              class="btn btn-primary">Tải
                                                              xuống</a>
                                                      @endif
                                                  </td>
                                                  <td>{{ $value->description }}</td>
                                                  <td>{{ date('H:i d/m/Y', strtotime($value->created_at)) }}</td>
                                                  <td>
                                                      <a class="btn btn-warning"
                                                          href="{{ url('teacher/homework/homework/edit/' . $value->id) }}">Sửa</a>
                                                      <a class="btn btn-danger"
                                                          href="{{ url('teacher/homework/homework/delete/' . $value->id) }}">Xóa</a>
                                                  </td>
                                              </tr>
                                          @endforeach


                                      </tbody>
                                  </table>

                                  <div style="padding: 10px; float: right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
                              </div>
                              <!-- /.card-body -->
                          </div>
                          <!-- /.card -->
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
