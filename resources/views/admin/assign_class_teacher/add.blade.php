  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm chủ nhiệm</h1>
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
                              <form id="form" method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label>Lớp học</label>
                                          <select name="class_id" class="form-control">
                                              @foreach ($getClass as $class)
                                                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>

                                      <div class="form-group">
                                          <label>Giáo viên <span style="color: red">*</span></label>

                                          @foreach ($getTeacher as $teacher)
                                              <div>
                                                  <label style="font-weight:700;">
                                                      <input name="teacher_id[]" value="{{ $teacher->id }}" type="checkbox"
                                                          value="{{ $teacher->id }}">{{ $teacher->name }}
                                                      {{ $teacher->last_name }}</input>
                                                  </label>
                                              </div>
                                          @endforeach

                                      </div>


                                      <div class="form-group">
                                          <label>Trạng thái</label>
                                          <select name="status" class="form-control">
                                              <option value="0">Hoạt động</option>
                                              <option value="1">Ngưng hoạt động</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/assign_class_vTeacher/list') }}"
                                          class="btn btn-danger">Hủy</a>
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
                      'teacher_id[]': {
                          required: true
                      }
                  },
                  messages: {
                      'teacher_id[]': {
                          required: "Bạn phải chọn ít nhất một giáo viên."
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
