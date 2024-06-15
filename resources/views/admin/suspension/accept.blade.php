@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Yêu cầu bảo lưu</h1>
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
                                            <div class="card card-info">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Thông tin lớp học bảo lưu
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><strong>Tên lớp:</strong>
                                                            {{ $data['getSuspension']->class_name }}</li>
                                                        <li class="list-group-item"><strong>Học phí:</strong>
                                                            {{ number_format($data['getSuspension']->fee) }} đ
                                                        </li>
                                                        <li class="list-group-item"><strong>Ngày khai giảng:</strong>
                                                            {{ date('d/m/Y', strtotime($data['getSuspension']->class_start_date)) }}
                                                        </li>
                                                        <li class="list-group-item"><strong>Ngày kết thúc:</strong>
                                                            {{ date('d/m/Y', strtotime($data['getSuspension']->class_end_date)) }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Tên học sinh <span style="color:red;">*</span></label>
                                            <input disabled
                                                value="{{ $data['getSuspension']->last_name }} {{ $data['getSuspension']->name }}"
                                                type="text" class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Email <span style="color:red;">*</span></label>
                                            <input disabled value="{{ $data['getSuspension']->email }}" type="text"
                                                class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Mã học sinh<span style="color:red;">*</span></label>
                                            <input disabled value="{{ $data['getSuspension']->student_id }}" type="text"
                                                class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Ngày tạo<span style="color:red;">*</span></label>
                                            <input disabled
                                                value="{{ date('d-m-Y', strtotime($data['getSuspension']->created_at)) }}"
                                                type="text" class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Ngày bảo lưu<span style="color:red;">*</span></label>
                                            <input disabled value="{{ $data['getSuspension']->start_date }}" type="date"
                                                class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Bảo lưu tới<span style="color:red;">*</span></label>
                                            <input disabled value="{{ $data['getSuspension']->end_date }}" type="date"
                                                class="form-control" @readonly(true)>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="amount">Tiền còn lại: <span style="color:red;">*</span></label>
                                            <input name="amount" value="{{ $data['getSuspension']->amount }}"
                                                type="number" class="form-control" id="amount">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="reason">Lý do<span style="color:red;">*</span></label>
                                            <textarea @readonly(true) disabled name="reason" required class="form-control" style="text-align: start"
                                                rows="8" id="reason">{{ $data['getSuspension']->reason }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ url('admin/suspension/list') }}" class="btn btn-default mr-4">Quay lại</a>
                                    <button id="cancelRequest" class="btn btn-danger"
                                        data-id="{{ $data['getSuspension']->id }}">Từ chối</button>
                                    <button style="width: 160px; margin-left: 16px;" type="submit"
                                        class="btn btn-success">Xác nhận yêu cầu</button>
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
            $('#cancelRequest').click(function(e) {
                e.preventDefault()
                const id = $(this).data('id');
                console.log(id)
                showLoading(true);
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/suspension/cancel') }}/" + id,
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    dataType: 'json',

                    success: function(data) {
                        showLoading(false);
                        if (data.success) {
                            window.location.href =
                                "{{ url('admin/suspension/list') }}";
                        } else {
                            showAlert('Lỗi', 'Vui lòng thử lại sau!');
                        }
                    },
                })
            });
        })
    </script>
@endsection
