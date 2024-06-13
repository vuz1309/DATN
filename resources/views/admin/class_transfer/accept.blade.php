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
                                            <div class="card card-info">
                                                <div class="card-header">
                                                    <h3 class="card-title"> Chuyển từ lớp <i class="fas fa-arrow-right"></i>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Tên lớp:</strong>
                                                            {{ $getFromClass->name }}</li>
                                                        <li class="list-group-item"><strong>Học phí:</strong>
                                                            {{ number_format($getFromClass->fee) }} đ
                                                        </li>
                                                        <li class="list-group-item"><strong>Ngày khai giảng:</strong>
                                                            {{ date('d/m/Y', strtotime($getFromClass->start_date)) }}</li>
                                                        <li class="list-group-item"><strong>Ngày kết thúc:</strong>
                                                            {{ date('d/m/Y', strtotime($getFromClass->end_date)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="card card-info">
                                                <div class="card-header">
                                                    <h3 class="card-title"> <i class="fas fa-arrow-right"></i> Chuyển sang
                                                        lớp
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Tên lớp:</strong>
                                                            {{ $getToClass->name }}</li>
                                                        <li class="list-group-item"><strong>Học phí:</strong>
                                                            {{ number_format($getToClass->fee) }} đ
                                                        </li>
                                                        <li class="list-group-item"><strong>Ngày khai giảng:</strong>
                                                            {{ date('d/m/Y', strtotime($getToClass->start_date)) }}</li>
                                                        <li class="list-group-item"><strong>Ngày kết thúc:</strong>
                                                            {{ date('d/m/Y', strtotime($getToClass->end_date)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group col-md-12">
                                            <label for="reason">Lý do chuyển lớp<span style="color:red;">*</span></label>
                                            <textarea @readonly(true) disabled name="reason" required class="form-control" id="reason" placeholder="">{{ $getTransfer->reason }}</textarea>
                                            <div style="color: red;">{{ $errors->first('reason') }}</div>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="request_date">Ngày yêu cầu<span style="color:red;">*</span></label>
                                            <input @readonly(true) disabled value="{{ $getTransfer->request_date }}"
                                                name="request_date" type="date" class="form-control" id="request_date"
                                                placeholder="">
                                            <div style="color: red;">{{ $errors->first('request_date') }}</div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="amount">Phí chuyển lớp<span style="color:red;">*</span></label>
                                            <input value="{{ !empty($getTransfer->amount) ? $getTransfer->amount : 0 }}"
                                                name="amount" type="number" class="form-control" id="amount"
                                                placeholder="">
                                            <div style="color: red;">{{ $errors->first('amount') }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Phản hồi<span style="color:red;">*</span></label>
                                            <textarea name="description" class="form-control" id="description" placeholder="">{{ !empty($getTransfer->description) ? $getTransfer->description : old('description') }}</textarea>
                                            <div style="color: red;">{{ $errors->first('description') }}</div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ url('admin/class_transfers/admin_list') }}"
                                        class="btn btn-default mr-4">Quay lại</a>
                                    <button id="cancelRequest" class="btn btn-danger">Từ chối</button>
                                    <button style="width: 160px; margin-left: 16px;" type="submit"
                                        class="btn btn-success">Xác nhận yêu
                                        cầu</button>
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
        $(function() {
            const transfer = @json($getTransfer);
            $('#cancelRequest').click(function(e) {

                const id = transfer.id;
                const description = $('#description').val();
                showLoading(true);
                $.ajax({
                    type: "POST",
                    url: "{{ url('student/transfer/cancel') }}/" + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        description
                    },
                    dataType: 'json',

                    success: function(data) {
                        showLoading(false);
                        if (data.success) {
                            window.location.href =
                                "{{ url('admin/class_transfers/admin_list') }}";
                        } else {
                            showAlert('Lỗi', 'Vui lòng thử lại sau!');
                        }
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        showLoading(false);
                        showAlert('Lỗi', 'Có lỗi xảy ra, vui lòng thử lại sau!');
                        console.error(xhr, status, error);
                    }

                })

            });
            $('#form').validate({
                rules: {
                    amount: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },
                messages: {
                    amount: {
                        required: 'Không được để trống.'
                    },
                    description: {
                        required: 'Không được để trống.'
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
