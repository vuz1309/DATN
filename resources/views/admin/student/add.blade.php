  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm mới học sinh</h1>
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
                      @include('_message')
                      <!-- /.col -->
                      <div class="col-md-12">

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
                                              <label for="admission_number">Mã học sinh <span
                                                      style="color:red;">*</span></label>
                                              <input name="admission_number" value="{{ old('admission_number') }}"
                                                  type="text" required class="form-control" id="admission_number"
                                                  placeholder="">
                                              <div style="color: red;">{{ $errors->first('admission_number') }}</div>

                                          </div>
                                          {{-- <div class="form-group col-md-6">
                                              <label for="roll_number">Roll number </label>
                                              <input value="{{ old('roll_number') }}" name="roll_number" type="text"
                                                  class="form-control" id="roll_number" placeholder="">
                                              <div style="color: red;">{{ $errors->first('roll_number') }}</div>
                                          </div> --}}


                                          <div class="form-group col-md-6">
                                              <label for="class_id">Lớp <span style="color:red;">*</span></label>
                                              <select required class="form-control" name="class_id">
                                                  <option value="">Chọn lớp học</option>
                                                  @foreach ($getClass as $class)
                                                      <option {{ old('class_id') == $class->id ? 'selected' : '' }}
                                                          value="{{ $class->id }}">{{ $class->name }}</option>
                                                  @endforeach
                                              </select>
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
                                              <label for="date_of_birth">Ngày sinh</label>
                                              <input value="{{ old('date_of_birth') }}" name="date_of_birth" type="date"
                                                  class="form-control" id="date_of_birth" placeholder="">
                                              <div style="color: red;">{{ $errors->first('date_of_birth') }}</div>

                                          </div>

                                          {{-- <div class="form-group col-md-6">
                                              <label for="caste">Khối <span style="color: red;">*</span></label>
                                              <input value="{{ old('caste') }}" name="caste" type="text" required
                                                  class="form-control" id="caste" placeholder="">
                                              <div style="color: red;">{{ $errors->first('caste') }}</div>

                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="religion">Tôn giáo</label>
                                              <input value="{{ old('religion') }}" name="religion" type="text"
                                                  class="form-control" id="religion" placeholder="">
                                              <div style="color: red;">{{ $errors->first('religion') }}</div>


                                          </div> --}}

                                          <div class="form-group col-md-6">
                                              <label for="mobile_number">Số điện thoại</label>
                                              <input value="{{ old('mobile_number') }}" name="mobile_number" type="text"
                                                  class="form-control" id="mobile_number" placeholder="">
                                              <div style="color: red;">{{ $errors->first('mobile_number') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="admission_date">Ngày nhập học</label>
                                              <input value="{{ old('admission_date') }}" name="admission_date"
                                                  type="date" class="form-control" id="admission_date" placeholder="">
                                              <div style="color: red;">{{ $errors->first('admission_date') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="profile_pic">Ảnh học sinh</label>
                                              <input value="{{ old('profile_pic') }}" name="profile_pic" type="file"
                                                  class="form-control" id="profile_pic" accept="image/*" placeholder="">
                                              <div style="color: red;">{{ $errors->first('profile_pic') }}</div>

                                          </div>

                                          {{-- <div class="form-group col-md-6">
                                              <label for="blood_group">Nhóm máu</label>
                                              <input value="{{ old('blood_group') }}" name="blood_group" type="text"
                                                  class="form-control" id="blood_group" placeholder="">
                                              <div style="color: red;">{{ $errors->first('blood_group') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="weight">Cân nặng</label>
                                              <input value="{{ old('weight') }}" name="weight" type="text"
                                                  class="form-control" id="weight" placeholder="">
                                              <div style="color: red;">{{ $errors->first('weight') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="height">Chiều cao</label>
                                              <input value="{{ old('height') }}" name="height" type="text"
                                                  class="form-control" id="height" placeholder="">
                                              <div style="color: red;">{{ $errors->first('height') }}</div>

                                          </div> --}}


                                          <div class="form-group col-md-6">
                                              <label for="status">Trạng thái <span style="color: red;">*</span></label>
                                              <select class="form-control" name="status">

                                                  <option {{ old('status') == '0' ? 'selected' : '' }} value="0">Đang
                                                      học</option>
                                                  <option {{ old('status') == '1' ? 'selected' : '' }} value="1">
                                                      Ngưng học tập</option>

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

                                  <div class="card-footer Vbetween">
                                      <a href="{{ url('admin/student/list') }}" class="btn btn-danger">Hủy</a>
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
