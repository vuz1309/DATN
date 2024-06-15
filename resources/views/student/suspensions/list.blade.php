@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Yêu cầu bảo lưu của tôi (Tổng: {{ $getRecord->total() }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a class="btn btn-primary" href="{{ url('student/suspension/add') }}">Thêm yêu cầu</a>
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
                                            <label for="admission_date">Ngày yêu cầu</label>
                                            <input name="admission_date" value="{{ Request::get('admission_date') }}"
                                                type="date" class="form-control" id="admission_date" placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                kiếm</button>
                                            <a href="{{ url('admin/suspension/list') }}" class="btn btn-success"
                                                style="margin-top:30px;">Làm mới</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                        <th>Tên học sinh</th>
                                        <th>Email</th>
                                        <th>Mã học sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày bảo lưu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Ngày yêu cầu</th>
                                        <th style="min-width: 160px">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($getRecord as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }} {{ $value->last_name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->student_id }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-info">Chưa duyệt</span>
                                                @elseif($value->status == 2)
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @elseif($value->status == 3)
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @elseif($value->status == 4)
                                                    <span class="badge bg-secondary">Đã kết thúc bảo lưu</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($value->start_date)) }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($value->end_date)) }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($value->created_at)) }}
                                            </td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <button id="cancelRequest" data-id="{{ $value->id }}" href="#"
                                                        class="btn btn-danger">
                                                        Hủy yêu cầu
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
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
                const id = $(this).data('id');
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
                            window.location.reload();
                        } else {
                            showAlert('Lỗi', 'Vui lòng thử lại sau!');
                        }
                        console.log(data)
                    },
                })
            });
        })
    </script>
@endsection
