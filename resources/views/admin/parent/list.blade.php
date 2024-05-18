  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách phụ huynh (Tổng: {{ $getRecord->total() }})</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('admin/parent/add') }}">Thêm mới</a>
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
                                              <label for="name">Họ tên</label>
                                              <input name="name" value="{{ Request::get('name') }}" type="text"
                                                  class="form-control" id="name" placeholder="">
                                          </div>


                                          <div class="form-group col-md-3">
                                              <label for="date">Ngày tạo</label>
                                              <input name="date" type="date" value="{{ Request::get('date') }}"
                                                  class="form-control" id="date" placeholder="">

                                          </div>
                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('admin/admin/list') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>


                          <div class="card">
                              @include('_message')
                              <!-- /.card-header -->
                              <div class="card-body p-0">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif
                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Ảnh</th>
                                              <th>Họ tên</th>
                                              <th>Email</th>
                                              <th>Số điện thoại</th>
                                              <th>Địa chỉ</th>
                                              <th>Giới tính</th>
                                              <th>Trạng thái</th>
                                              <th>Ngày tạo</th>
                                              <th>Hành động</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($getRecord as $value)
                                              <tr>
                                                  <td>{{ $value->id }}</td>
                                                  <td>
                                                      <img style="width: 50px; height: 50px; border-radius: 50%"
                                                          src="{{ $value->getProfile() }}" />
                                                  </td>
                                                  <td>{{ $value->name }} {{ $value->last_name }}</td>
                                                  <td>{{ $value->email }} </td>
                                                  <td>{{ $value->mobile_number }} </td>
                                                  <td>{{ $value->address }} </td>
                                                  <td>
                                                      @if ($value->gender == 1)
                                                          Nam
                                                      @elseif($value->gender == 2)
                                                          Nữ
                                                      @elseif($value->gender == 3)
                                                          Khác
                                                      @endif
                                                  </td>
                                                  <td>
                                                      @if ($value->status == 0)
                                                          Đang hoạt động
                                                      @else
                                                          Ngưng hoạt động
                                                      @endif

                                                  </td>
                                                  <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                  <td>
                                                      <a href="{{ url('admin/parent/edit/' . $value->id) }}"
                                                          class="btn btn-primary">Sửa</a>
                                                      <a href="{{ url('admin/parent/delete/' . $value->id) }}"
                                                          class="btn btn-danger">Xóa</a>
                                                      <a href="{{ url('admin/parent/my-student/' . $value->id) }}"
                                                          class="btn btn-warning">Học sinh</a>
                                                      <a href="{{ url('chat?receiver_id=' . $value->id) }}"
                                                          class="btn btn-info">Trò chuyện</a>
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
