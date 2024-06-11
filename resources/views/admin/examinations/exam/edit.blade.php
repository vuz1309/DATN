  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm mới bài thi</h1>
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
                              <form id="form" method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label for="name">Tên<span style="color: red;">*</span></label>
                                          <input name="name" value="{{ $getRecord->name }}" type="text" required
                                              class="form-control" id="name" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label style="font-weight:700;">
                                              <input disabled {{ $getRecord->is_all ? 'checked' : '' }} class="allCheckbox"
                                                  id="allCheckbox" name="allCheckbox" type="checkbox">Cho tất cả các lớp +
                                              Khóa học</input>
                                          </label>
                                      </div>
                                      <div id="optionClassSubject">
                                          <div class="form-group">
                                              <label for="class_id">Lớp<span style="color: red;">*</span></label>
                                              <input type="text" readonly class="form-control"
                                                  value="{{ $getRecord->class_name }}">
                                          </div>
                                          <div class="form-group ">
                                              <label for="subject_id">Khóa học<span style="color: red;">*</span></label>
                                              <input type="text" readonly class="form-control"
                                                  value="{{ $getRecord->subject_name }}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="note">Ghi chú</label>
                                          <textarea name="note" class="form-control" id="note">
                  {{ $getRecord->note }}
                 </textarea>
                                          <div style="color: red;">{{ $errors->first('note') }}</div>
                                      </div>


                                  </div>

                                  <div class="card-footer">
                                      <div>
                                          <a href="{{ url('admin/examinations/exam/list') }}" class="btn btn-danger">Hủy</a>
                                          <button type="submit" class="btn btn-primary">Cập nhật</button>
                                      </div>
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
          $(document).ready(function() {

              $('#form').validate({
                  rules: {
                      name: {
                          required: true,
                      },
                  },
                  messages: {
                      name: {
                          required: 'Không được để trống'
                      },
                      class_id: {
                          required: 'Không được để trống',
                      },
                      subject_id: {
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
              $('.allCheckbox').each(function(e) {
                  const checked = this.checked;

                  const optionClasssubject = $('#optionClassSubject');
                  if (checked) {
                      optionClasssubject.css('display', 'none');
                  } else {
                      optionClasssubject.css('display', 'block');

                  }
              });
          });
      </script>
  @endsection
