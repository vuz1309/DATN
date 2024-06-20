@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quay lại sau bảo lưu</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @include('_message')
                    <div class="col-md-12">
                        <div class="card card-primary">

                            <form id="form" method="post" action="">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="class_id">Học lớp <span style="color:red;">*</span></label>
                                            <select required class="form-control" id="class_id" name="class_id">
                                                <option value="">Chọn lớp học</option>
                                                @foreach ($getNotMyClass as $class)
                                                    <option {{ old('class_id') == $class->id ? 'selected' : '' }}
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


                                        <div class="form-group col-md-12">
                                            <label for="amount">Số tiền còn lại trước bảo lưu: <span
                                                    style="color:red;">*</span></label>
                                            <span class="form-control disabled">{{ number_format($getSuspension->amount) }}
                                            </span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="need_amount">Số tiền cần đóng học cho lớp này: <span
                                                    style="color:red;">*</span></label>
                                            <input id="need_amount" name="need_amount"
                                                type="
                                            number"
                                                class="form-control">
                                            </input>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ url('vAdmin/suspension/list') }}" class="btn btn-default mr-4">Quay lại</a>

                                    <button style="width: 160px; margin-left: 16px;" type="submit"
                                        class="btn btn-success">Xác nhận quay lại sau bảo lưu</button>
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
    <script>
        $(function() {

            $('#form').validate({
                rules: {
                    class_id: {
                        required: true
                    },
                    reason: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    need_amount: {
                        required: true,
                        min: 0
                    }
                },
                messages: {
                    need_amount: {
                        required: 'Không được để trống.',
                        min: 'Ít nhất là 1.000đ'
                    },
                    class_id: {
                        required: 'Không được để trống.'
                    },
                    start_date: {
                        required: 'Không được để trống.'
                    },
                    reason: {
                        required: 'Không được để trống.'
                    },
                    end_date: {
                        required: 'Không được để trống.'
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

            var classData = @json($getNotMyClass);


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
                    $('#need_amount').val(selectedClass.fee);
                } else {
                    $('#' + prefix + '-class-name').text('');
                    $('#' + prefix + '-class-fee').text('');
                    $('#' + prefix + '-class-start-date').text('');
                    $('#' + prefix + '-class-end-date').text('');
                }
            }

            $('#class_id').on('change', function() {
                var selectedClassId = $(this).val();
                updateClassInfo(selectedClassId, classData, 'from');
            });

        })
    </script>
@endsection
