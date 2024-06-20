  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách Khóa học các lớp (Tổng: {{ $getRecord->total() }})</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('vAdmin/assign_subject/add') }}">Thêm mới</a>
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

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-3">
                                              <label for="subject_name">Tên Khóa học</label>
                                              <input name="subject_name" value="{{ Request::get('subject_name') }}"
                                                  type="text" class="form-control" id="subject_name" placeholder="">
                                          </div>

                                          <div class="form-group col-md-3">
                                              <label for="class_name">Tên lớp học</label>
                                              <input name="class_name" value="{{ Request::get('class_name') }}"
                                                  type="text" class="form-control" id="class_name" placeholder="">
                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="teacher_name">Tên giáo viên</label>
                                              <input name="teacher_name" value="{{ Request::get('teacher_name') }}"
                                                  type="text" class="form-control" id="teacher_name" placeholder="">
                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="date">Ngày tạo</label>
                                              <input name="date" type="date" value="{{ Request::get('date') }}"
                                                  class="form-control" id="date" placeholder="">

                                          </div>
                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('vAdmin/assign_subject/list') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>


                          <div class="card">

                              <!-- /.card-header -->
                              <div class="card-body p-0">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif
                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Lớp học</th>
                                              <th>Khóa học</th>
                                              <th>Giáo viên dạy</th>
                                              <th>Trạng thái</th>
                                              <th>Tạo bởi</th>
                                              <th>Ngày tạo</th>
                                              <th>Hành động</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($getRecord as $value)
                                              <tr>
                                                  <td>{{ $value->id }}</td>
                                                  <td>{{ $value->class_name }}</td>
                                                  <td>{{ $value->subject_name }}</td>
                                                  <td>{{ $value->teacher_name }} {{ $value->teacher_last_name }}</td>
                                                  <td>
                                                      @if ($value->status == 0)
                                                          Đang hoạt động
                                                      @else
                                                          Ngưng hoạt động
                                                      @endif

                                                  </td>
                                                  <td>{{ $value->created_by_name }}</td>
                                                  <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                  <td>
                                                      <a href="{{ url('vAdmin/assign_subject/edit_single/' . $value->id) }}"
                                                          class="btn btn-primary">Sửa 1</a>
                                                      <a href="{{ url('vAdmin/assign_subject/edit/' . $value->id) }}"
                                                          class="btn btn-primary">Sửa nhiều</a>
                                                      <a href="{{ url('vAdmin/assign_subject/delete/' . $value->id) }}"
                                                          class="btn btn-danger">Xóa</a>
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
