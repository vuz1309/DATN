  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Đổi mật khẩu</h1>
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

                          <div class="card card-primary">

                              <!-- form start -->
                              <form id="form" method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label for="old_password">Mật khẩu cũ <span style="color: red">*</span></label>
                                          <input name="old_password" type="password" required class="form-control"
                                              id="old_password" placeholder="">
                                      </div>

                                      <div class="form-group">
                                          <label for="new_password">Mật khẩu mới <span style="color: red">*</span></label>
                                          <input name="new_password" type="password" required class="form-control"
                                              id="new_password" placeholder="">
                                      </div>

                                      <div class="form-group">
                                          <label for="confirm_new_password">Nhập lại mật khẩu mới <span
                                                  style="color: red">*</span></label>
                                          <input name="confirm_new_password" type="password" required class="form-control"
                                              id="confirm_new_password" placeholder="">
                                      </div>

                                  </div>

                                  <div class="card-footer">
                                      <button type="submit" style="min-width: 160px;" class="btn btn-primary">Đổi mật
                                          khẩu</button>
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
                      old_password: {
                          required: true
                      },
                      new_password: {
                          required: true,
                          minlength: 6 // Đặt độ dài tối thiểu cho mật khẩu mới
                      },
                      confirm_new_password: {
                          required: true,
                          equalTo: "#new_password" // Đảm bảo mật khẩu mới nhập lại khớp với mật khẩu mới
                      }
                  },
                  messages: {
                      old_password: {
                          required: "Vui lòng nhập mật khẩu cũ"
                      },
                      new_password: {
                          required: "Vui lòng nhập mật khẩu mới",
                          minlength: "Mật khẩu mới phải có ít nhất 6 ký tự"
                      },
                      confirm_new_password: {
                          required: "Vui lòng nhập lại mật khẩu mới",
                          equalTo: "Mật khẩu nhập lại không khớp"
                      }
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
