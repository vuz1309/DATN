  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm lớp học</h1>
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

                      <!-- /.col -->
                      <div class="col-md-12">

                          <div class="card card-primary">

                              <!-- form start -->
                              <form id="form" method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label for="name">Tên lớp <span style="color:red;">*</span></label>
                                          <input name="name" type="text" required class="form-control" id="name"
                                              placeholder="">
                                          <div style="color: red;">{{ $errors->first('email') }}</div>
                                      </div>
                                      <div class="form-group">
                                          <label for="name">Ngày bắt đầu (Khai giảng) <span
                                                  style="color:red;">*</span></label>
                                          <input name="start_date" type="date" required class="form-control"
                                              id="start_date" placeholder="">
                                          <div style="color: red;">{{ $errors->first('start_date') }}</div>
                                      </div>
                                      <div class="form-group">
                                          <label for="name">Ngày kết thúc <span style="color:red;">*</span></label>
                                          <input name="end_date" type="date" required class="form-control" id="end_date"
                                              placeholder="">
                                          <div style="color: red;">{{ $errors->first('end_date') }}</div>
                                      </div>
                                      <div class="form-group">
                                          <label for="fee">Học phí <span style="color:red;">*</span></label>
                                          <input name="fee" type="number" required class="form-control" id="fee"
                                              placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Trạng thái</label>
                                          <select name="status" class="form-control">
                                              <option value="0">Đang hoạt động</option>
                                              <option value="1">Ngừng hoạt động</option>
                                          </select>
                                      </div>


                                  </div>

                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/class/list') }}" class="btn btn-danger">Hủy</a>
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
              // Thêm phương thức kiểm tra end_date lớn hơn start_date
              $.validator.addMethod("checkEndDate", function(value, element) {
                  var startDate = $('#start_date').val(); // Lấy giá trị start_date
                  var endDate = value; // Giá trị end_date

                  // Chuyển đổi định dạng ngày thành đối tượng Date
                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  // Kiểm tra end_date lớn hơn start_date
                  return end > start;
              }, 'Ngày kết thúc phải lớn hơn ngày bắt đầu.');

              $('#form').validate({
                  rules: {
                      name: {
                          required: true,
                      },
                      fee: {
                          required: true,
                          min: 0
                      },
                      end_date: {
                          required: true,
                          checkEndDate: true // Thêm kiểm tra checkEndDate cho end_date
                      },
                      start_date: {
                          required: true
                      }
                  },
                  messages: {
                      name: {
                          required: 'Không được để trống',
                      },
                      fee: {
                          required: 'Không được để trống',
                          min: 'Học phí phải lớn hơn 0'
                      },
                      end_date: {
                          required: 'Không được để trống',
                          checkEndDate: 'Ngày kết thúc phải lớn hơn ngày bắt đầu.'
                      },
                      start_date: {
                          required: 'Không được để trống',
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
