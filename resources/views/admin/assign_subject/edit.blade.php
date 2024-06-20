  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Sửa gán Khóa học cho lớp</h1>
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
                              <form method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label>Lớp học</label>
                                          <select name="class_id" class="form-control">
                                              @foreach ($getClass as $class)
                                                  <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                                      value="{{ $class->id }}">{{ $class->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>

                                      <div class="form-group">
                                          <label>Khóa học</label>

                                          @foreach ($getSubject as $index => $subject)
                                              @php

                                                  $checked = '';
                                                  $teacher_id = '';
                                              @endphp

                                              @foreach ($getAssignSubjectID as $subjectAssign)
                                                  @if ($subjectAssign->subject_id == $subject->id)
                                                      @php
                                                          $checked = 'checked';
                                                          $teacher_id = $subjectAssign->teacher_id;
                                                      @endphp
                                                  @endif
                                              @endforeach

                                              <div
                                                  style="margin-top: 8px; border: 1px solid #ccc; padding: 16px; border-radius: 8px;">
                                                  <label style="font-weight:700;">
                                                      <input class="SubjectCheckbox" id="{{ $index }}"
                                                          {{ $checked }} id="{{ $index }}" name="subject_id[]"
                                                          type="checkbox"
                                                          value="{{ $subject->id }}">{{ $subject->name }}</input>
                                                  </label>
                                                  <div class="form-group">
                                                      <label for="teacher_id">Giáo viên dạy</label>
                                                      <select id="Teacher{{ $index }}" name="teacher_id[]"
                                                          class="form-control">
                                                          @foreach ($getTeacher as $teacher)
                                                              <option {{ $teacher_id == $teacher->id ? 'selected' : '' }}
                                                                  value="{{ $teacher->id }}">{{ $teacher->name }}
                                                                  {{ $teacher->last_name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                          @endforeach

                                      </div>

                                      <div class="form-group">
                                          <label>Trạng thái</label>
                                          <select name="status" class="form-control">
                                              <option {{ $getRecord->status == '0' ? 'selected' : '' }} value="0">Hoạt
                                                  động</option>
                                              <option {{ $getRecord->status == '1' ? 'selected' : '' }} value="1">
                                                  Ngưng
                                                  hoạt động</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="card-footer">
                                      <a href="{{ url('vAdmin/assign_subject/list') }}" class="btn btn-danger">Hủy</a>
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
          $(document).ready(function() {


              $('.SubjectCheckbox').each(function() {

                  const id = $(this).attr('id');
                  const teacherBox = $(`#Teacher${id}`);
                  if (this.checked) {
                      teacherBox.prop('disabled', false);
                  } else {
                      teacherBox.prop('disabled', true);
                  }
              });

          });
          $('.SubjectCheckbox').change(function(e) {
              const checked = this.checked;
              console.log('check:', checked)
              const id = $(this).attr('id');
              const teacherBox = $(`#Teacher${id}`);
              if (checked) {
                  teacherBox.prop('disabled', false);
              } else {
                  teacherBox.prop('disabled', true);
              }
          });
      </script>
  @endsection
