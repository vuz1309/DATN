@extends('layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bài tập</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('_message')
                        <div class="card card-primary">
                            <form id="form" action="" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Lớp<span style="color: red">*</span></label>
                                        <select required style="width: 100%;" name="class_id" class="form-control getClass">
                                            <option value="">---Chọn---</option>
                                            @foreach ($getClass as $class)
                                                <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                                    value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Môn học<span style="color: red">*</span></label>
                                        <select required style="width: 100%;" name="subject_id"
                                            class="form-control getSubject">
                                            @foreach ($getSubject as $subject)
                                                <option
                                                    {{ $getRecord->subject_id == $subject->subject_id ? 'selected' : '' }}
                                                    value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Thời gian bắt đầu<span style="color: red">*</span></label>
                                        <input value="{{ $getRecord->homework_date }}" required class="form-control"
                                            type="datetime-local" name="homework_date" id="homework_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hạn<span style="color: red">*</span></label>
                                        <input value="{{ $getRecord->submission_date }}" required class="form-control"
                                            type="datetime-local" name="submission_date" id="submission_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tài liệu</label>
                                        <input class="form-control" type="file" name="document_file" id="document_file">
                                        @if (!empty($getRecord->getDocument()))
                                            <a download="" href="{{ $getRecord->getDocument() }}"
                                                class="btn btn-primary">Tải
                                                xuống</a>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Mô tả</label>
                                        <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px">{{ $getRecord->description }}</textarea>
                                    </div>
                                </div>
                                <div class="card-footer"><a href="{{ url('teacher/homework/homework') }}"
                                        class="btn btn-danger">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

@section('script')
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            $('.getClass').change(function() {
                const class_id = $(this).val();
                $.ajax({
                    url: "{{ url('teacher/class_timeable/get_teacher_subject_class') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: class_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        $('.getSubject').html(response.html);
                    }
                })
            });
            $.validator.addMethod("greaterThanHomeworkDate", function(value, element) {
                var homeworkDate = $('#homework_date').val(); // Lấy giá trị ngày bài tập
                // Chuyển đổi các giá trị ngày thành các đối tượng Date để so sánh
                var homeworkDateObj = new Date(homeworkDate);
                var submissionDateObj = new Date(value);
                // So sánh ngày
                return submissionDateObj > homeworkDateObj;
            }, "Ngày nộp bài phải sau ngày bài tập");
            $('#form').validate({
                rules: {
                    homework_date: {
                        required: true,

                    },
                    submission_date: {
                        required: true,
                        greaterThanHomeworkDate: true
                    },



                },
                messages: {
                    submission_date: {
                        required: 'Không được để trống',
                        greaterThanHomeworkDate: "Ngày nộp bài phải sau ngày bài tập"

                    },
                    homework_date: {
                        required: 'Không được để trống',


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

            $('#compose-textarea').summernote({
                height: 200
            });
        })
    </script>
@endsection
