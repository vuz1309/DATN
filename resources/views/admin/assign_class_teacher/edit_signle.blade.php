  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Sửa chủ nhiệm</h1>
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

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label>Lớp học</label>
                                          <select name="class_id" class="form-control">
                                              @foreach ($getClass as $class)
                                                  <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                                      value="{{ $class->id }}">{{ $class->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>

                                      <div class="form-group">
                                          <label>Giáo viên</label>

                                          <select name="teacher_id" class="form-control">
                                              @foreach ($getTeacher as $teacher)
                                                  <option {{ $getRecord->teacher_id == $teacher->id ? 'selected' : '' }}
                                                      value="{{ $teacher->id }}">{{ $teacher->name }}
                                                      {{ $teacher->last_name }}</option>
                                              @endforeach
                                          </select>

                                      </div>



                                      <div class="form-group">
                                          <label>Trạng thái</label>
                                          <select name="status" class="form-control">
                                              <option {{ $getRecord->status == '0' ? 'selected' : '' }} value="0">Hoạt
                                                  động</option>
                                              <option {{ $getRecord->status == '1' ? 'selected' : '' }} value="1">Ngưng
                                                  hoạt động</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/assign_class_vTeacher/list') }}"
                                          class="btn btn-danger">Hủy</a>
                                      <button type="submit" class="btn btn-primary">Cập nhật</button>
                                  </div>

                              </form>
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
