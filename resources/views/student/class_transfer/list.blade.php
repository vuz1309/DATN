@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Yêu cầu chuyển lớp (Tổng: {{ $listTransfer->total() }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a class="btn btn-primary" href="{{ url('student/move/add') }}">Thêm yêu cầu</a>
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
                                            <label for="class">Tên lớp</label>
                                            <input name="class" value="{{ Request::get('class') }}" type="text"
                                                class="form-control" id="class" placeholder="">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control" name="status">
                                                <option {{ empty(Request::get('status')) ? 'selected' : '' }}
                                                    value="">Tất cả</option>
                                                <option {{ Request::get('status') == '1' ? 'selected' : '' }}
                                                    value="1">Chờ duyệt</option>
                                                <option {{ Request::get('status') == '2' ? 'selected' : '' }}
                                                    value="2">Đang xử lý</option>
                                                <option {{ Request::get('status') == '3' ? 'selected' : '' }}
                                                    value="3">Đã duyệt</option>
                                                <option {{ Request::get('status') == '4' ? 'selected' : '' }}
                                                    value="4">Đã hủy</option>


                                            </select>
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="request_date">Ngày yêu cầu</label>
                                            <input name="request_date" value="{{ Request::get('request_date') }}"
                                                type="date" class="form-control" id="request_date" placeholder="">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                kiếm</button>
                                            <a href="{{ url('student/move') }}" class="btn btn-success"
                                                style="margin-top:30px;">Làm mới</a>
                                        </div>

                                    </div>


                                </div>

                            </form>
                        </div>


                        <div class="card">
                            <div class="card-header">

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
                                            <th>Từ lớp</th>
                                            <th>Đến lớp</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày yêu cầu</th>
                                            <th>Phí chuyển lớp</th>
                                            <th>Chú thích</th>
                                            <th style="min-width: 160px">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listTransfer as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->from_class_name }}</td>
                                                <td>{{ $value->to_class_name }}</td>


                                                <td>
                                                    @if ($value->status == 1)
                                                        <span class="badge bg-info">Chờ xử lý</span>
                                                    @elseif($value->status == 2)
                                                        <span class="badge bg-warning">Đang xử lý</span>
                                                    @elseif($value->status == 3)
                                                        <span class="badge bg-success">Đã duyệt</span>
                                                    @elseif($value->status == 4)
                                                        <span class="badge bg-danger">Đã hủy</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!@empty($value->request_date))
                                                        {{ date('d-m-Y', strtotime($value->request_date)) }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $value->amount }}
                                                </td>
                                                <td>
                                                    {{ $value->description }}
                                                </td>

                                                <td>

                                                    @if ($value->status == 1)
                                                        <a href="{{ url('student/transfer/remove/' . $value->id) }}"
                                                            class="btn btn-danger">Xóa yêu cầu</a>
                                                    @elseif($value->status == 2)
                                                        <a href="{{ url('student/transfer/payFee/' . $value->id) }}"
                                                            class="btn btn-info">Xác nhận chuyển lớp</a>
                                                        <button id="cancelRequest" data-id="{{ $value->id }}"
                                                            href="#" class="btn btn-danger">Hủy yêu cầu</button>
                                                    @elseif($value->status == 3)

                                                    @elseif($value->status == 4)
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                                <div style="padding: 10px; float: right;">{!! $listTransfer->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
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


    </div>
@endsection

@section('script')
    <script>
        $(function() {


            $('#cancelRequest').click(function(e) {
                const id = null;
                console.log(e);
                showLoading(true);
                $.ajax({
                    type: "POST",
                    url: "{{ url('student/transfer/cancel') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    dataType: 'json',

                    success: function(data) {
                        showLoading(false);
                    },

                })

            });
        })
    </script>
@endsection
