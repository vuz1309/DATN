  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách Khóa học</h1>
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

                          <!-- /.card -->

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-3">
                                              <label for="name">Tên Khóa học</label>
                                              <input name="name" value="{{ Request::get('name') }}" type="text"
                                                  class="form-control" id="name" placeholder="">
                                          </div>

                                          <div class="form-group col-md-3">
                                              <label>Thể loại</label>
                                              <select name="type" class="form-control">
                                                  <option {{ Request::get('type') == '' ? 'selected' : '' }} value="">
                                                      Tất cả</option>
                                                  <option {{ Request::get('type') == 'Lý thuyết' ? 'selected' : '' }}
                                                      value="Lý thuyết">Lý thuyết</option>
                                                  <option {{ Request::get('type') == 'Thực hành' ? 'selected' : '' }}
                                                      value="Thực hành">Thực hành</option>
                                              </select>

                                          </div>

                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('student/my_subject') }}" class="btn btn-success"
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
                                              <th>Khóa học</th>
                                              <th>Thể loại</th>

                                          </tr>
                                      </thead>
                                      <tbody>
                                          @if (!empty($getRecord))
                                              @foreach ($getRecord as $value)
                                                  <tr>
                                                      <td>{{ $value->id }}</td>
                                                      <td>{{ $value->subject_name }}</td>
                                                      <td>{{ $value->subject_type }}</td>
                                                  </tr>
                                              @endforeach
                                          @endif





                                      </tbody>
                                  </table>

                                  <div style="padding: 10px; float: right;"></div>
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
