  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm mới quản lý</h1>
                      </div>
                      <!-- <div class="col-sm-6" style="text-align: right;">
                                                <a href="{{ url('admin/dashboard') }}"></a>
                                              </div> -->
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
                              <form id="form" method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-6">
                                              <label for="name">Họ <span style="color:red;">*</span></label>
                                              <input name="name" value="{{ old('name') }}" type="text" required
                                                  class="form-control" id="name" placeholder="">
                                              <div style="color: red;">{{ $errors->first('name') }}</div>

                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="last_name">Tên <span style="color:red;">*</span></label>
                                              <input name="last_name" value="{{ old('last_name') }}" type="text" required
                                                  class="form-control" id="last_name" placeholder="">
                                              <div style="color: red;">{{ $errors->first('last_name') }}</div>

                                          </div>
                                          <div class="form-group col-md-12">
                                              <label for="email">Email <span style="color: red;">*</span></label>

                                              <div class="input-group mb-3">
                                                  <div class="input-group-append">
                                                      <div class="input-group-text">
                                                          <span class="fas fa-envelope"></span>
                                                      </div>
                                                  </div>
                                                  <input value="{{ old('email') }}" name="email" type="email" required
                                                      class="form-control" id="email" placeholder="">

                                              </div>
                                              <div style="color: red;">{{ $errors->first('email') }}</div>
                                          </div>

                                          <div class="form-group col-md-12">
                                              <label for="password">Mật khẩu đăng nhập <span
                                                      style="color: red;">*</span></label>

                                              <div class="input-group mb-3">
                                                  <div class="input-group-append">
                                                      <div class="input-group-text">
                                                          <span class="fas fa-lock"></span>
                                                      </div>
                                                  </div>
                                                  <input value="{{ !empty(old('password')) ? old('password') : '123456' }}"
                                                      name="password" type="password" required class="form-control"
                                                      id="password" placeholder="">

                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="card-footer">
                                      <a href="{{ url('admin/admin/list') }}" class="btn btn-danger">Hủy</a>
                                      <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                      last_name: {
                          required: true,

                      },
                      password: {

                          minlength: 6,

                      },

                      email: {
                          required: true,
                          email: true,

                      },


                  },
                  messages: {
                      name: {
                          required: 'Không được để trống',


                      },
                      last_name: {
                          required: 'Không được để trống',


                      },
                      password: {
                          required: true,
                          minlength: 'Độ dài tối thiểu: 6',

                      },
                      admission_number: {
                          required: 'Không được để trống',

                      },
                      email: {
                          required: 'Không được để trống',
                          email: 'Cần đúng định dạng email',

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
