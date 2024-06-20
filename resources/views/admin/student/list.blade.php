  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Danh sách học sinh (Tổng: {{ $getRecord->total() }})</h1>
                      </div>
                      <div class="col-sm-6" style="text-align: right;">
                          <a class="btn btn-primary" href="{{ url('vAdmin/vStudent/add') }}">Thêm mới</a>
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

                          <!-- /.card -->

                          <div class="card card-primary">

                              <!-- form start -->
                              <form method="get" action="">

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="form-group col-md-3">
                                              <label for="name">Tên học sinh</label>
                                              <input name="name" value="{{ Request::get('name') }}" type="text"
                                                  class="form-control" id="name" placeholder="">
                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="email">Email</label>
                                              <input name="email" value="{{ Request::get('email') }}" type="text"
                                                  class="form-control" id="email" placeholder="">
                                          </div>



                                          <div class="form-group col-md-3">
                                              <label for="class_id">Lớp</label>
                                              <select class="form-control" name="class_id">
                                                  <option value="">Chọn lớp học</option>
                                                  @foreach ($getClass as $class)
                                                      <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                          value="{{ $class->id }}">{{ $class->name }}</option>
                                                  @endforeach
                                              </select>

                                          </div>
                                          <div class="form-group col-md-3">
                                              <label for="gender">Giới tính</label>
                                              <select class="form-control" name="gender">
                                                  <option {{ empty(Request::get('gender')) ? 'selected' : '' }}
                                                      value="">Tất cả</option>
                                                  <option {{ Request::get('gender') == '1' ? 'selected' : '' }}
                                                      value="1">Nam</option>
                                                  <option {{ Request::get('gender') == '2' ? 'selected' : '' }}
                                                      value="2">Nữ</option>
                                                  <option {{ Request::get('gender') == '3' ? 'selected' : '' }}
                                                      value="3">Khác</option>


                                              </select>
                                          </div>


                                          <div class="form-group col-md-3">
                                              <label for="admission_date">Ngày nhập học</label>
                                              <input name="admission_date" value="{{ Request::get('admission_date') }}"
                                                  type="date" class="form-control" id="admission_date" placeholder="">
                                          </div>

                                          <div class="form-group col-md-3">
                                              <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                  kiếm</button>
                                              <a href="{{ url('vAdmin/vStudent/list') }}" class="btn btn-success"
                                                  style="margin-top:30px;">Làm mới</a>
                                          </div>

                                      </div>


                                  </div>

                              </form>
                          </div>


                          <div class="card">
                              <div class="card-header">
                                  <div>
                                      <button id="importExcel" class="btn btn-default" data-toggle="modal"
                                          data-target="#modal-lg">
                                          <i class="fas fa-file-import"></i>
                                          Nhập khẩu
                                      </button>
                                      <form style="display: inline-block" method="post"
                                          action="{{ url('vAdmin/vStudent/export') }}">
                                          {{ csrf_field() }}
                                          <button class="btn btn-info"> <i class="fas fa-file-export"></i> Xuất khẩu toàn bộ
                                          </button>
                                      </form>
                                  </div>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body p-0" style="overflow: auto;">
                                  @if (empty($noUseTools))
                                      <div id="tools"></div>
                                  @endif

                                  <table id="tableList" class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Ảnh</th>
                                              <th>Họ và tên</th>
                                              <th>Email</th>
                                              <th>Phụ huynh</th>
                                              <th>Mã học sinh</th>

                                              <th>Lớp</th>
                                              <th>Ngày sinh</th>
                                              <th>Giới tính</th>


                                              <th>Trạng thái</th>

                                              <th>Ngày tạo</th>
                                              <th style="min-width: 160px">Hành động</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($getRecord as $value)
                                              <tr>
                                                  <td>{{ $value->id }}</td>
                                                  <td>

                                                      <img style="width: 50px; height: 50px; border-radius: 50%"
                                                          src="{{ $value->getProfile() }}" />

                                                  </td>
                                                  <td>{{ $value->name }} {{ $value->last_name }}</td>
                                                  <td>{{ $value->email }} </td>
                                                  <td>{{ $value->parent_name }} {{ $value->parent_last_name }}</td>
                                                  <td>{{ $value->admission_number }} </td>

                                                  <td>{{ $value->class_name }} </td>
                                                  <td>
                                                      @if (!@empty($value->date_of_birth))
                                                          {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                                      @endif
                                                  </td>

                                                  <td>
                                                      @if ($value->gender == 1)
                                                          Nam
                                                      @elseif($value->gender == 2)
                                                          Nữ
                                                      @elseif($value->gender == 3)
                                                          Khác
                                                      @endif
                                                  </td>


                                                  <td>
                                                      @if ($value->status == 0)
                                                          Đang hoạt động
                                                      @else
                                                          Ngưng hoạt động
                                                      @endif
                                                  </td>

                                                  <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                  <td>
                                                      <a href="{{ url('vAdmin/vStudent/edit/' . $value->id) }}"
                                                          class="btn btn-primary">Sửa</a>
                                                      <a href="{{ url('vAdmin/vStudent/delete/' . $value->id) }}"
                                                          class="btn btn-danger">Xóa</a>
                                                      <a href="{{ url('chat?receiver_id=' . $value->id) }}"
                                                          class="btn btn-info">Trò chuyện</a>
                                                  </td>
                                              </tr>
                                          @endforeach


                                      </tbody>
                                  </table>

                                  <div style="padding: 10px; float: right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
                              </div>
                              <!-- /.card-body -->
                          </div>
                          <!-- /.card -->
                      </div>
                      <!-- /.col -->
                  </div>
                  <!-- /.row -->

                  <!-- /.row -->
              </div><!-- /.container-fluid -->
          </section>
          @include('_alert_dialog')
          <!-- /.content -->
          <div class="modal fade" id="modalImport">

              <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                      <div class="loading"
                          style="position: absolute;
                     height: 100%;
                     width: 100%;
                     background-color: rgba(255, 255, 255, 0.6);
                     z-index: 999999;
                     display: flex;
                     align-items: center;
                     justify-content: center;
                 ">
                          <div
                              style="
                 width: 50px;
                 height: 50px;
                 border: 8px solid #dddddd;
                 border-top-color: #1975d7;
                 border-radius: 50%;
                 animation: loading 0.5s ease infinite;">
                          </div>
                      </div>
                      <div class="modal-header">
                          <h4 class="modal-title">Nhập khẩu học sinh</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">

                          <div class="bs-stepper">
                              <div class="bs-stepper-header" role="tablist">
                                  <!-- your steps here -->
                                  <div class="step" data-target="#logins-part">
                                      <button type="button" class="step-trigger" role="tab"
                                          aria-controls="logins-part" id="logins-part-trigger">
                                          <span class="bs-stepper-circle">1</span>
                                          <span class="bs-stepper-label">Chọn file</span>
                                      </button>
                                  </div>
                                  <div class="line"></div>
                                  <div class="step" data-target="#information-part">
                                      <button type="button" class="step-trigger" role="tab"
                                          aria-controls="information-part" id="information-part-trigger">
                                          <span class="bs-stepper-circle">2</span>
                                          <span class="bs-stepper-label">Kết quả nhập khẩu</span>
                                      </button>
                                  </div>
                              </div>
                              <div class="bs-stepper-content">
                                  <!-- your steps content here -->
                                  <div id="logins-part" class="content" role="tabpanel"
                                      aria-labelledby="logins-part-trigger">
                                      <div class="custom-file">
                                          <input value="{{ old('file') }}" name="file" type="file"
                                              class="form-control custom-file-input" id="fileImport">

                                          <label class="custom-file-label" for="file">Chọn file excel</label>
                                      </div>

                                      <div style="margin-top: 24px;">
                                          <p>Vui lòng <a id="downloadTemplate"
                                                  href="{{ url('download/student_template') }}">Tải mẫu file nhập khẩu</a>
                                              về nếu chưa từng nhập
                                              khẩu.</p>
                                      </div>
                                  </div>
                                  <div id="information-part" class="content" role="tabpanel"
                                      aria-labelledby="information-part-trigger">
                                      <div id="errorResult" style="display: none;max-height: 50vh;overflow-y: auto">
                                          <p
                                              style="font-size: 18px;
                                          font-style: italic;
                                          font-family: auto;">
                                              Nhập khẩu thành công! Các dòng lỗi không thể nhập khẩu, vui lòng kiểm tra lại.
                                          </p>
                                          <table style="height: 100%;" class="table table-danger">
                                              <thead>
                                                  <th>Hàng</th>
                                                  <th>Thuộc tính</th>
                                                  <th>Lỗi</th>
                                                  <th>Giá trị</th>
                                              </thead>
                                              <tbody id="errorsImport">

                                              </tbody>

                                          </table>
                                      </div>
                                      <div id="successResult">
                                          <div style="display: flex; height: 50vh">
                                              <p
                                                  style="color: green;
                                              font-size: 38px;
                                              font-weight: 600;
                                              margin: auto;
                                              font-style: italic;
                                              font-family: 'Font Awesome 5 Free';
                                          ">
                                                  Nhập khẩu thành công!</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                          <button id="submitImport" type="button" class="btn btn-primary">Tiếp tục</button>

                      </div>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
      </div>
  @endsection

  @section('script')
      <script>
          function convertToTitle(str) {
              if (str === 'ho') return 'Họ';
              if (str === 'ma_hoc_sinh') return 'Mã học sinh';
              if (str === 'ten') return 'Tên';
              if (str === 'mat_khau') return 'Mật khẩu';
              if (str === 'lop') return 'Lớp';
              return str;
          }
          $(function() {
              $(document).ready(function() {
                  var stepper = new Stepper($('.bs-stepper')[0])
              })
              $('#datemask').inputmask('dd/mm/yyyy', {
                  'placeholder': 'dd/mm/yyyy'
              });
              $('#importExcel').click(function() {
                  $(document).ready(function() {
                      var stepper = new Stepper($('.bs-stepper')[0])
                  })
                  $('#modalImport').modal('show');
                  $('#submitImport').show();
                  $('.loading').fadeOut();
              });
              bsCustomFileInput.init();
              $('#importForce').hide();

              $('#submitImport').click(function() {
                  const file = $('#fileImport')[0].files[0];

                  if (!file) {
                      showAlert('Lỗi', 'Vui lòng chọn một file để nhập khẩu.');
                      return;
                  }

                  // Kiểm tra phần mở rộng của tên file có là .xlsx không
                  const fileName = file.name;
                  const fileExtension = fileName.split('.').pop()
                      .toLowerCase(); // Lấy phần mở rộng và chuyển thành chữ thường
                  if (fileExtension !== 'xlsx') {
                      showAlert('Lỗi', 'Vui lòng chọn một file có định dạng xlsx.');
                      return;
                  }
                  var formData = new FormData();
                  formData.append('file', $('#fileImport')[0].files[0]);
                  formData.append('_token', '{{ csrf_token() }}');
                  $.ajax({
                      url: "{{ url('vAdmin/vStudent/import') }}",
                      type: "POST",
                      data: formData,

                      processData: false,
                      contentType: false,
                      beforeSend: function() {
                          // Hiển thị biểu tượng loading trước khi gửi request
                          $('.loading').fadeIn();
                      },
                      dataType: "json",
                      success: function(response) {
                          $('.loading').fadeOut();
                          console.log(response);
                          if (response.success === false) {
                              var html = '';
                              response.errors && response.errors.length && response.errors
                                  .forEach((item) => {
                                      html += `<tr><td>${item.row}</td>
                                        <td>${convertToTitle(item.attribute)}</td>
                                        <td>${(item.errors[0]) }</td>
                                        <td>${item.values[item.attribute] === undefined || item.values[item.attribute] === null ? 'Không có giá trị' : item.values[item.attribute] }</td></tr>
                                        `
                                  });
                              $('#errorsImport').html(html);


                              $('#submitImport').hide();
                              $('#errorResult').show();

                              $('#successResult').hide();
                          } else {
                              $('#successResult').show();
                              $('#submitImport').hide();
                          }

                          var stepper = new Stepper(document.querySelector('.bs-stepper'))
                          stepper.next()
                      }
                  })

              });
          })
      </script>
  @endsection
