  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Con cái phụ huynh: <span style="font-weight: bold;">{{ $getParent->name }}
                                  {{ $getParent->last_name }} </span></h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('vAdmin/vParent/add') }}">Thêm mới</a>
                      </div>
                  </div>
              </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="row">
                      @include('_message')
                      <!-- /.col -->
                      <div class="col-md-12">

                          <!-- /.card -->

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">
                                  <div class="card-header"> Tìm học sinh</div>
                                  <div class="card-body">
                                      <div class="row">

                                          <div class="form-group col-md-3">
                                              <label for="id">Mã học sinh</label>
                                              <input name="id" value="{{ Request::get('id') }}" type="text"
                                                  class="form-control" id="id" placeholder="">
                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="name">Tên học sinh</label>
                                              <input name="name" value="{{ Request::get('name') }}" type="text"
                                                  class="form-control" id="name" placeholder="">
                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="email">Email</label>
                                              <input name="email" value="{{ Request::get('email') }}" type="text"
                                                  class="form-control" id="email" placeholder="">
                                          </div>

                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('vAdmin/vStudent/list') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>




                          <div class="card">

                              <div class="card-header">Học sinh</div>
                              <div class="card-body p-0" style="overflow: auto;">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif
                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Ảnh</th>
                                              <th>Họ và tên</th>
                                              <th>Email</th>
                                              <th>Phụ huynh</th>
                                              <th>Ngày tạo</th>
                                              <th style="min-width: 160px">Hành động</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @if (!empty($getSearchStudents))
                                              @foreach ($getSearchStudents as $value)
                                                  <tr>
                                                      <td>{{ $value->id }}</td>
                                                      <td>
                                                          @if (!empty($value->profile_pic))
                                                              <img style="width: 50px; height: 50px; border-radius: 50%"
                                                                  src="{{ url('upload/profile/' . $value->profile_pic) }}" />
                                                          @endif
                                                      </td>
                                                      <td>{{ $value->name }} {{ $value->last_name }}</td>
                                                      <td>{{ $value->email }} </td>
                                                      <td>{{ $value->parent_name }} </td>

                                                      <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                      <td>
                                                          <a href="{{ url('vAdmin/vParent/assign_student_vParent/' . $value->id . '/' . $parent_id) }}"
                                                              class="btn btn-primary">Thêm </a>
                                                      </td>
                                                  </tr>
                                              @endforeach
                                          @endif

                                      </tbody>
                                  </table>

                              </div>
                              <!-- /.card-body -->
                          </div>

                          <div class="card">
                              <div class="card-header">Con cái phụ huynh</div>
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
                                                      @if (!empty($value->profile_pic))
                                                          <img style="width: 50px; height: 50px; border-radius: 50%"
                                                              src="{{ url('upload/profile/' . $value->profile_pic) }}" />
                                                      @endif
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

                                                      <a href="{{ url('vAdmin/vParent/assign_student_parent_delete/' . $value->id) }}"
                                                          class="btn btn-danger">Xóa</a>

                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>


                              </div>
                              <!-- /.card-body -->
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
