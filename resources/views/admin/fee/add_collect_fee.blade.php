@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Học phí (<span style="color:blue">{{ $getStudent->name }} {{ $getStudent->last_name }}</span>)
                        </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <button id="AddFees" class="btn btn-primary">Nộp học phí</button>

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
                        @include('_message')
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body p-0" style="overflow: auto;">
                                @if (empty($noUseTools))
                                    <div id="tools"></div>
                                @endif
                                <table id="tableList" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 10px">#</th>


                                            <th>Hình thức</th>
                                            <th>Số tiền nộp</th>
                                            {{-- <th>Còn lại</th> --}}
                                            <th>Tổng học phí</th>
                                            <th>Ghi chú</th>
                                            <th>Người tạo</th>
                                            <th>Ngày tạo</th>
                                            <th style="min-width: 160px">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>

                                                <td>{{ $value->payment_type == 1 ? 'Tiền mặt' : 'Chuyển khoản' }}</td>
                                                <td>{{ number_format($value->paid_amount) }} đ</td>
                                                {{-- <td>{{ number_format($value->remaining_amount) }} đ</td> --}}
                                                <td>{{ number_format($value->fee) }} đ</td>
                                                <td>{{ $value->remark }}</td>
                                                <td>{{ $value->created_name }}</td>
                                                <td>{{ date('d-m-Y H:m', strtotime($value->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ url('admin/fee/add_fees/delete/' . $value->id) }}"
                                                        class="btn btn-danger">Xóa</a>

                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="100%">Không có bản ghi</td>
                                        @endforelse




                                    </tbody>
                                </table>

                                {{-- <div style="padding: 10px; float: right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div> --}}
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
    <div class="modal fade" id="AddFeesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nộp học phí </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <form id="form" action="" method="post">
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Tổng học phí:
                                <span>{{ number_format($getStudent->amount) }} đ</span></label>
                            <input type="hidden" value="{{ $getStudent->amount }}" />

                        </div>
                        <div class="form-group">
                            <label for="paid_amount" class="col-form-label">Đã đóng:
                                <span>{{ number_format($paid_amount) }} đ</span></label>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Còn lại:
                                <span>{{ number_format($getStudent->amount - $paid_amount) }} đ</span></label>

                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Số tiền <span style="color: red">*</span></label>
                            <input value="{{ $getStudent->amount - $paid_amount }}" name='amount' required type="number"
                                class="form-control" id="amount">


                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Tiền bằng chữ: </label>
                            <span id="amount_text" style="font-style: italic; margin-left: 4px;"></span>

                        </div>
                        <div class=" form-group">
                            <label for="payment_type" class="col-form-label">Hình thức thanh toán <span
                                    style="color: red">*</span></label>
                            <select required class="form-control" name="payment_type" id="payment_type">
                                <option value="1">Tiền mặt</option>
                                <option value="2">Chuyển khoản</option>
                            </select>
                        </div>
                        <div class=" form-group">
                            <label for="remark" class="col-form-label">Ghi chú</label>
                            <textarea class="form-control" id="remark">
                            </textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#AddFees').click(function() {

                $('#AddFeesModal').modal('show');

            });

            $('#amount').each(function() {
                const amount = $(this).val();


                const words = numberToWords(parseInt(amount));

                $('#amount_text').html(words);
            });
            $('#amount').change(function() {
                const amount = $(this).val();


                const words = numberToWords(parseInt(amount));

                $('#amount_text').html(words);
            });
            $('#form').validate({
                rules: {
                    amount: {
                        required: true,
                        min: 1000,
                        max: {{ $getStudent->amount - $paid_amount }}

                    },




                },
                messages: {

                    amount: {
                        required: 'Không được để trống',
                        min: 'Cần đóng ít nhất 1000đ',
                        max: 'Đã vượt quá số tiền cần đóng.'

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
        })
    </script>
@endsection
