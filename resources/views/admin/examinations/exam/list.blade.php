  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách bài thi (Tổng: {{ $getRecord->total() }})</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('vAdmin/examinations/exam/add') }}">Thêm mới</a>
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
                              <div class="card-header">Tìm kiếm</div>
                              <!-- form start -->
                              <form method="get" action="">

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-3">
                                              <label for="name">Tên</label>
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
                                              <a href="{{ url('vAdmin/examinations/exam/list') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>


                          <div class="card">
                              <div class="card-header">Danh sách bài thi</div>
                              <!-- /.card-header -->
                              <div class="card-body p-0">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif
                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Tên</th>
                                              <th>Lớp</th>
                                              <th>Môn</th>
                                              <th>Ghi chú</th>
                                              <th>Ngày tạo</th>
                                              <th>Người tạo</th>
                                              <th>Hành động</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($getRecord as $value)
                                              <tr>
                                                  <td>{{ $value->id }}</td>
                                                  <td>{{ $value->name }}</td>
                                                  <td>{{ $value->is_all == 0 ? $value->class_name : 'Toàn bộ' }}</td>
                                                  <td>{{ $value->is_all == 0 ? $value->subject_name : 'Toàn bộ' }}</td>

                                                  <td>{{ $value->note }}</td>

                                                  <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                  <td>{{ $value->created_by_name }}</td>

                                                  <td>
                                                      <a href="{{ url('vAdmin/examinations/exam/edit/' . $value->id) }}"
                                                          class="btn btn-primary">Sửa</a>
                                                      <a href="{{ url('vAdmin/examinations/exam/delete/' . $value->id) }}"
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
