@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Yêu cầu chuyển lớp</h1>
                    </div>
                </div>
            </div>
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
                            <form id="form" method="post" action="">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="from_class_id">Chuyển từ lớp <span
                                                    style="color:red;">*</span></label>
                                            <select required class="form-control" id="from_class_id" name="from_class_id">
                                                <option value="">Chọn lớp học</option>
                                                @foreach ($getMyClass as $class)
                                                    <option {{ old('from_class_id') == $class->id ? 'selected' : '' }}
                                                        value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="card card-info" style="margin-top: 16px;">
                                                <div class="card-header">
                                                    <h3 class="card-title">Thông tin lớp <i class="fas fa-arrow-right"></i>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Tên lớp:</strong> <span
                                                                id="from-class-name"></span></li>
                                                        <li class="list-group-item"><strong>Học phí:</strong> <span
                                                                id="from-class-fee"></span> đ</li>
                                                        <li class="list-group-item"><strong>Ngày khai giảng:</strong> <span
                                                                id="from-class-start-date"></span></li>
                                                        <li class="list-group-item"><strong>Ngày kết thúc:</strong> <span
                                                                id="from-class-end-date"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="to_class_id">Sang lớp <span style="color:red;">*</span></label>
                                            <select required class="form-control" id="to_class_id" name="to_class_id">
                                                <option value="">Chọn lớp học</option>
                                                @foreach ($getNotMyClass as $class)
                                                    <option {{ old('to_class_id') == $class->id ? 'selected' : '' }}
                                                        value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="card card-info" style="margin-top: 16px;">
                                                <div class="card-header">
                                                    <h3 class="card-title"><i class="fas fa-arrow-right"></i> Thông tin lớp
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Tên lớp:</strong> <span
                                                                id="to-class-name"></span></li>
                                                        <li class="list-group-item"><strong>Học phí:</strong> <span
                                                                id="to-class-fee"></span> đ</li>
                                                        <li class="list-group-item"><strong>Ngày khai giảng:</strong> <span
                                                                id="to-class-start-date"></span></li>
                                                        <li class="list-group-item"><strong>Ngày kết thúc:</strong> <span
                                                                id="to-class-end-date"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="reason">Lý do chuyển lớp<span style="color:red;">*</span></label>
                                            <textarea name="reason" required class="form-control" id="reason" placeholder="">{{ old('reason') }}</textarea>
                                            <div style="color: red;">{{ $errors->first('reason') }}</div>

                                        </div>




                                        <div class="form-group col-md-6">
                                            <label for="request_date">Ngày yêu cầu<span style="color:red;">*</span></label>
                                            <input value="{{ old('request_date') }}" name="request_date" type="date"
                                                class="form-control" id="request_date" placeholder="">
                                            <div style="color: red;">{{ $errors->first('request_date') }}</div>

                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer Vbetween">
                                    <a href="{{ url('student/move') }}" class="btn btn-danger mr-4">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var classData = @json($getMyClass);
            var notMyClassData = @json($getNotMyClass);

            function updateClassInfo(classId, classData, prefix) {
                var selectedClass = classData.find(function(classItem) {
                    return classItem.id == classId;
                });

                if (selectedClass) {
                    $('#' + prefix + '-class-name').text(selectedClass.name);
                    $('#' + prefix + '-class-fee').text(new Intl.NumberFormat().format(selectedClass.fee));
                    $('#' + prefix + '-class-start-date').text(new Date(selectedClass.start_date)
                        .toLocaleDateString());
                    $('#' + prefix + '-class-end-date').text(new Date(selectedClass.end_date).toLocaleDateString());
                } else {
                    $('#' + prefix + '-class-name').text('');
                    $('#' + prefix + '-class-fee').text('');
                    $('#' + prefix + '-class-start-date').text('');
                    $('#' + prefix + '-class-end-date').text('');
                }
            }

            $('#from_class_id').on('change', function() {
                var selectedClassId = $(this).val();
                updateClassInfo(selectedClassId, classData, 'from');
            });

            $('#to_class_id').on('change', function() {
                var selectedClassId = $(this).val();
                updateClassInfo(selectedClassId, notMyClassData, 'to');
            });

            // Kích hoạt sự kiện change để cập nhật thông tin ban đầu nếu có lớp học được chọn sẵn
            $('#from_class_id').trigger('change');
            $('#to_class_id').trigger('change');

            $('#form').validate({
                rules: {
                    from_class_id: {
                        required: true,

                    },
                    to_class_id: {
                        required: true,

                    },
                    reason: {
                        required: true,


                    },
                    request_date: {
                        required: true,

                    },
                },
                messages: {
                    from_class_id: {
                        required: 'Không được để trống',

                    },
                    to_class_id: {
                        required: 'Không được để trống',

                    },
                    reason: {
                        required: 'Không được để trống',


                    },
                    request_date: {
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
