  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Sửa thông tin học sinh</h1>
                      </div>
                      <!-- <div class="col-sm-6" style="text-align: right;">
                                                                                                         <a href="{{ url('vAdmin/dashboard') }}"></a>
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
                                              <input name="name" value="{{ $getRecord->name }}" type="text" required
                                                  class="form-control" id="name" placeholder="">
                                              <div style="color: red;">{{ $errors->first('name') }}</div>

                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="last_name">Tên <span style="color:red;">*</span></label>
                                              <input name="last_name" value="{{ $getRecord->last_name }}" type="text"
                                                  required class="form-control" id="last_name" placeholder="">
                                              <div style="color: red;">{{ $errors->first('last_name') }}</div>

                                          </div>


                                          <div class="form-group col-md-6">
                                              <label for="admission_number">Mã học sinh <span
                                                      style="color:red;">*</span></label>
                                              <input name="admission_number" value="{{ $getRecord->admission_number }}"
                                                  type="text" required class="form-control" id="admission_number"
                                                  placeholder="">
                                              <div style="color: red;">{{ $errors->first('admission_number') }}</div>

                                          </div>



                                          {{-- <div class="form-group col-md-6">
                                              <label for="class_id">Lớp <span style="color:red;">*</span></label>
                                              <select class="form-control" required name="class_id">
                                                  <option value="">Chọn lớp học</option>
                                                  @foreach ($getClass as $class)
                                                      <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                                          value="{{ $class->id }}">{{ $class->name }}</option>
                                                  @endforeach
                                              </select>
                                          </div> --}}

                                          <div class="form-group col-md-6">
                                              <label for="gender">Giới tính</label>
                                              <select class="form-control" name="gender">

                                                  <option {{ $getRecord->gender == '1' ? 'selected' : '' }} value="1">
                                                      Nam</option>
                                                  <option {{ $getRecord->gender == '2' ? 'selected' : '' }} value="2">
                                                      Nữ</option>
                                                  <option {{ $getRecord->gender == '3' ? 'selected' : '' }} value="3">
                                                      Khác</option>
                                              </select>
                                              <div style="color: red;">{{ $errors->first('gender') }}</div>

                                          </div>



                                          <div class="form-group col-md-6">
                                              <label for="date_of_birth">Ngày sinh</label>
                                              <input name="date_of_birth" value="{{ $getRecord->date_of_birth }}"
                                                  type="date" class="form-control" id="date_of_birth" placeholder="">
                                              <div style="color: red;">{{ $errors->first('date_of_birth') }}</div>

                                          </div>



                                          <div class="form-group col-md-6">
                                              <label for="mobile_number">Số điện thoại</label>
                                              <input name="mobile_number" value="{{ $getRecord->mobile_number }}"
                                                  type="text" class="form-control" id="mobile_number" placeholder="">
                                              <div style="color: red;">{{ $errors->first('mobile_number') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="admission_date">Ngày nhập học</label>
                                              <input name="admission_date" value="{{ $getRecord->admission_date }}"
                                                  type="date" class="form-control" id="admission_date" placeholder="">
                                              <div style="color: red;">{{ $errors->first('admission_date') }}</div>

                                          </div>

                                          <div class="form-group col-md-6">
                                              <label for="profile_pic">Ảnh học sinh</label>
                                              <div class="custom-file">
                                                  <input value="{{ old('profile_pic') }}" name="profile_pic" type="file"
                                                      class="form-control custom-file-input" id="profile_pic"
                                                      accept="image/*" onchange="displayImage(this)">

                                                  <label class="custom-file-label" for="profile_pic">Chọn ảnh</label>
                                              </div>

                                              <img id="profile_pic_preview" src="{{ $getRecord->getProfile() }}"
                                                  style="width: 50px; height:50px; object-fit: cover; margin-top: 12px; border-radius: 50%;" />


                                          </div>


                                          <div class="form-group col-md-6">
                                              <label for="status">Trạng thái <span style="color: red;">*</span></label>
                                              <select class="form-control" name="status">
                                                  <option {{ $getRecord->status == '0' ? 'selected' : '' }}
                                                      value="0">Đang học</option>
                                                  <option {{ $getRecord->status == '1' ? 'selected' : '' }}
                                                      value="1">Ngưng học tập</option>

                                              </select>
                                          </div>

                                      </div>



                                      <div class="form-group col-md-12">
                                          <label for="email">Email <span style="color: red;">*</span></label>
                                          <input name="email" value="{{ $getRecord->email }}" type="email" required
                                              class="form-control" id="email" placeholder="">

                                          <div style="color: red;">{{ $errors->first('email') }}</div>
                                      </div>

                                      <div class="form-group col-md-12">
                                          <label for="password">Mật khẩu đăng nhập <span
                                                  style="color: red;">*</span></label>
                                          <input name="password" type="password" class="form-control" id="password"
                                              placeholder="">
                                          <p>Nhập mật khẩu nếu bạn muốn thay đổi mật khẩu của học sinh.</p>
                                      </div>


                                  </div>

                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/vStudent/list') }}" class="btn btn-danger mr-4">Hủy</a>
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
          function displayImage(input) {
              var preview = document.getElementById('profile_pic_preview');
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                      preview.src = e.target.result;
                  };
                  reader.readAsDataURL(input.files[0]);
              } else {
                  preview.src = "";
              }
          }
          $(function() {



              bsCustomFileInput.init();
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
