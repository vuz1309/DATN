@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Báo cáo học phí
                        </h1>
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
                            <form method="get" action="">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="name">Tên học sinh</label>
                                            <input name="name" value="{{ Request::get('name') }}" type="text"
                                                class="form-control" id="name" placeholder="">
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
                                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                kiếm</button>
                                            <a href="{{ url('admin/fee/fee_collect_report') }}" class="btn btn-success"
                                                style="margin-top:30px;">Làm mới</a>
                                        </div>

                                    </div>


                                </div>

                            </form>
                        </div>

                        @include('_message')
                        <div class="card">
                            <div class="card-header">
                                <div style="display: flex; justify-content: space-between; align-items: center">
                                    <h5>Danh sách học phí</h5>
                                    <form method="post" action="{{ url('admin/fee/fee_collection_report_export') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-warning">Xuất khẩu
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
                                            <th style="min-width: 10px">#</th>
                                            <th>Mã học sinh</th>
                                            <th>Học sinh</th>
                                            <th>Lớp</th>
                                            <th>Hình thức</th>
                                            <th>Số tiền nộp</th>
                                            <th>Còn lại</th>
                                            <th>Tổng học phí</th>
                                            <th>Ghi chú</th>
                                            <th>Người tạo</th>
                                            <th>Ngày tạo</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->student_name }} {{ $value->student_last_name }}</td>
                                                <td>{{ $value->class_name }}</td>

                                                <td>{{ $value->payment_type == 1 ? 'Tiền mặt' : 'Chuyển khoản' }}</td>
                                                <td>{{ number_format($value->paid_amount) }} đ</td>
                                                <td>{{ number_format($value->remaining_amount) }} đ</td>
                                                <td>{{ number_format($value->fee) }} đ</td>
                                                <td>{{ $value->remark }}</td>
                                                <td>{{ $value->created_name }}</td>
                                                <td>{{ date('H:i d/m/Y', strtotime($value->created_at)) }}</td>


                                            </tr>
                                        @empty
                                            <td colspan="100%">Không có bản ghi</td>
                                        @endforelse




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
        <!-- /.content -->
    </div>
@endsection

{{-- @section('script')
    <script>
        $('#Export').click(() => {
            $.ajax({
                type: "POST",
                url: "{{ url('admin/fee/fee_collection_report_export') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {


                },

            })
        });
    </script>
@endsection --}}
