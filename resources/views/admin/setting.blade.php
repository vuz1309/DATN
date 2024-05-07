  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Cài đặt</h1>
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
                                      <div class="form-group">
                                          <label for="school_logo">Ảnh trường học</label>

                                          <div class="custom-file">
                                              <input value="{{ old('school_logo') }}" name="school_logo" type="file"
                                                  class="form-control custom-file-input" id="school_logo" accept="image/*"
                                                  onchange="displayImage(this)">

                                              <label class="custom-file-label" for="school_logo">Chọn ảnh</label>
                                          </div>

                                          <img id="profile_pic_preview" src="{{ $getRecord->getProfile() }}"
                                              style=" width: 80px; height:80px; object-fit: cover; margin-top: 12px; margin-left: 50%; transform: translateX(-50%); border-radius: 50%;" />
                                      </div>
                                      <div class="form-group">
                                          <label for="logo_school">Tên trường học <span style="color: red">*</span></label>
                                          <input name="school_name" value="{{ $getRecord->school_name }}" type="text"
                                              required class="form-control" id="school_name" placeholder="">
                                      </div>

                                  </div>

                                  <div class="card-footer">
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
                      school_name: {
                          required: true,

                      },



                  },
                  messages: {
                      school_name: {
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
