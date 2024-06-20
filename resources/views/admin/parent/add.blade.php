  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm mới phụ huynh</h1>
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
                          <div class="card card-primary">

                              <!-- form start -->
                              <form id="form" method="post" action="" enctype="multipart/form-data">
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
                                          <div class="form-group col-md-6">
                                              <label for="gender">Giới tính</label>
                                              <select class="form-control" name="gender">

                                                  <option {{ old('gender') == '1' ? 'selected' : '' }} value="1">Nam
                                                  </option>
                                                  <option {{ old('gender') == '2' ? 'selected' : '' }} value="2">Nữ
                                                  </option>
                                                  <option {{ old('gender') == '3' ? 'selected' : '' }} value="3">Khác
                                                  </option>
                                              </select>
                                              <div style="color: red;">{{ $errors->first('gender') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="occupation">Nghề nghiệp</label>
                                              <input value="{{ old('occupation') }}" name="occupation" type="text"
                                                  class="form-control" id="occupation" placeholder="">
                                              <div style="color: red;">{{ $errors->first('occupation') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="mobile_number">Số điện thoại</label>
                                              <input value="{{ old('mobile_number') }}" name="mobile_number" type="text"
                                                  class="form-control" id="mobile_number" placeholder="">
                                              <div style="color: red;">{{ $errors->first('mobile_number') }}</div>

                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="address">Địa chỉ</label>
                                              <input value="{{ old('address') }}" name="address" type="text"
                                                  class="form-control" id="address" placeholder="">
                                              <div style="color: red;">{{ $errors->first('address') }}</div>

                                          </div>



                                          <div class="form-group col-md-6">
                                              <label for="profile_pic">Ảnh</label>
                                              <input value="{{ old('profile_pic') }}" name="profile_pic" type="file"
                                                  class="form-control" id="profile_pic" placeholder="">
                                              <div style="color: red;">{{ $errors->first('profile_pic') }}</div>

                                          </div>


                                          <div class="form-group col-md-6">
                                              <label for="status">Trạng thái <span style="color: red;">*</span></label>
                                              <select class="form-control" name="status">

                                                  <option value="0">Đang hoạt động</option>
                                                  <option value="1">Ngưng sử dụng</option>

                                              </select>
                                          </div>

                                      </div>



                                      <div class="form-group col-md-12">
                                          <label for="email">Email <span style="color: red;">*</span></label>
                                          <input value="{{ old('email') }}" name="email" type="email" required
                                              class="form-control" id="email" placeholder="">

                                          <div style="color: red;">{{ $errors->first('email') }}</div>
                                      </div>

                                      <div class="form-group col-md-12">
                                          <label for="password">Mật khẩu đăng nhập <span
                                                  style="color: red;">*</span></label>
                                          <input value="{{ old('password') }}" name="password" type="password" required
                                              class="form-control" id="password" placeholder="">
                                      </div>


                                  </div>

                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/vParent/list') }}" class="btn btn-danger">Hủy</a>
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
                          required: true,
                          minlength: 6,

                      },
                      admission_number: {
                          required: true,

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
                          required: 'Không được để trống',
                          minlength: 'Độ dài tối thiểu: 6',
                      },
                      admission_number: {
                          required: 'Không được để trống',

                      },
                      email: {
                          required: 'Không được để trống',
                          email: 'Cần đúng định dạng email',

                      },
                      class_id: {
                          required: 'Không được để trống'
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
