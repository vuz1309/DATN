  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Sửa Khóa học</h1>
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
                                          <label for="name">Tên môn <span style="color: red;">*</span></label>
                                          <input name="name" type="text" value="{{ $getRecord->name }}"
                                              class="form-control" id="name" placeholder="">
                                          <div style="color: red;">{{ $errors->first('email') }}</div>
                                      </div>
                                      <div class="form-group">
                                          <label>Thể loại</label>
                                          <select name="type" class="form-control">
                                              <option {{ $getRecord->type == 'Lý thuyết' ? 'selected' : '' }}
                                                  value="Lý thuyết">Lý thuyết</option>
                                              <option {{ $getRecord->type == 'Thực hành' ? 'selected' : '' }}
                                                  value="Thực hành">Thực hành</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label>Trạng thái</label>
                                          <select name="status" class="form-control">
                                              <option {{ $getRecord->status == 0 ? 'selected' : '' }} value="0">Đang
                                                  hoạt động</option>
                                              <option {{ $getRecord->status == 1 ? 'selected' : '' }} value="1">Ngừng
                                                  hoạt động</option>
                                          </select>
                                      </div>


                                  </div>

                                  <div class="card-footer">
                                      <a href="{{ url('admin/subject/list') }}" class="btn btn-danger">Hủy</a>
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
  @section('script')
      <script type="text/javascript">
          $(function() {

              $('#form').validate({
                  rules: {
                      name: {
                          required: true,

                      },

                  },
                  messages: {
                      name: {
                          required: 'Không được để trống',


                      },

                  },
                  errorElement: 'span',
                  errorPlacement: function(error, element) {
                      error.addClass('invalid-feedback');
                      element.closest('.form-group').append(error);
                  },
                  highlight: function(element, errorClass, validClass) {
                      $(element).addClass('is-invalid');
                  },
                  unhighlight: function(element, errorClass, validClass) {
                      $(element).removeClass('is-invalid');
                  }
              });
          });
      </script>
  @endsection
