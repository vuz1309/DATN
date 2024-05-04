@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm mới thang điểm</h1>
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
                                    <input name="id" type="hidden" value="{{ $getRecord->id }}" required
                                        class="form-control" id="id" value="{{ $getRecord->name }}" placeholder="">
                                    <div class="form-group">
                                        <label for="name">Tên<span style="color: red;">*</span></label>
                                        <input name="name" type="text" required class="form-control" id="name"
                                            value="{{ $getRecord->name }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="percent_from">Điểm từ<span style="color: red;">*</span></label>
                                        <input value="{{ $getRecord->percent_from }}" name="percent_from" type="number"
                                            required step="0.01" class="form-control" id="percent_from" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="percent_to">Điểm đến<span style="color: red;">*</span></label>
                                        <input value="{{ $getRecord->percent_to }}" name="percent_to" step="0.01"
                                            type="number" required class="form-control" id="percent_to" placeholder="">
                                    </div>
                                </div>

                                <div style="gap: 20px; display: flex; justify-content: space-between; padding: 16px;">
                                    <a href="{{ url('admin/examinations/marks_grade') }}" class="btn btn-danger">Hủy</a>
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
        $(function() {

            $.validator.addMethod("checkPercent", function(value, element) {
                var isValid = false;

                // Gửi request đến server để kiểm tra percent
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/validate-percent') }}",
                    data: {
                        percent: value
                    },
                    async: false, // Chờ kết quả trả về trước khi tiếp tục
                    success: function(response) {
                        isValid = response !== 'true';
                    }
                });

                return isValid;
            });

            $('#form').validate({
                rules: {
                    percent_from: {
                        required: true,
                        number: true,
                        min: 0,
                        checkPercent: true
                    },
                    percent_to: {
                        required: true,
                        number: true,
                        min: 0,
                        checkPercent: true
                    },
                    name: {
                        required: true,
                    }
                },
                messages: {
                    percent_from: {
                        required: "Vui lòng nhập điểm từ",
                        number: "Vui lòng nhập một số",
                        min: "Điểm từ phải lớn hơn hoặc bằng 0",
                        checkPercent: 'Điểm từ đang nằm trong khoảng điểm khác, vui lòng thay đổi'
                    },
                    percent_to: {
                        required: "Vui lòng nhập điểm đến",
                        number: "Vui lòng nhập một số",
                        min: "Điểm đến phải lớn hơn hoặc bằng 0",
                        checkPercent: 'Điểm đến đang nằm trong khoảng điểm khác, vui lòng thay đổi'
                    },
                    name: {
                        required: "Vui lòng nhập tên",
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

        })
    </script>
@endsection
