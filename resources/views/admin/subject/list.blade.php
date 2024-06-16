  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách Khóa học (Tổng: {{ $getRecord->total() }})</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a href="{{ url('admin/subject/add') }}">Thêm mới</a>
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
                                              <label for="date">Ngày tạo</label>
                                              <input name="date" type="date" value="{{ Request::get('date') }}"
                                                  class="form-control" id="date" placeholder="">

                                          </div>
                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('admin/subject/list') }}" class="btn btn-success"
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
                                                  <td>{{ $value->name }}</td>
                                                  <td>{{ $value->type }}</td>
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
                                                      @if (empty($isView) || !$isView)
                                                          <a href="{{ url('admin/subject/edit/' . $value->id) }}"
                                                              class="btn btn-primary">Sửa</a>
                                                          <a href="{{ url('admin/subject/delete/' . $value->id) }}"
                                                              class="btn btn-danger">Xóa</a>
                                                      @endif

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
