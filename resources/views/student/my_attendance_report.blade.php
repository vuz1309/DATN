@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Điểm danh (Tổng: {{ $getRecord->total() }})</h1>
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
                        <!-- /.card -->

                        <div class="card card-primary">

                            <!-- form start -->
                            <form method="get" action="">
                                <div class="card-header">Tìm kiếm</div>

                                <div class="card-body">
                                    <div class="row">


                                        <div class="form-group col-md-3">
                                            <label for="class_id">Lớp học</label>
                                            <select id="getClass" class="form-control getClass" name="class_id">
                                                <option value="">Chọn lớp học</option>
                                                @if (!empty($getClass))
                                                    @foreach ($getClass as $class)
                                                        <option
                                                            {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                            value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="student_name">Tên học sinh</label>
                                            <input value="{{ Request::get('student_name') }}" type="text"
                                                class="form-control getClass" name="student_name">

                                            </input>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="subject_id">Môn học</label>
                                            <select id="getSubject" class="form-control getSubject" name="subject_id">
                                                <option value="">----Chọn----</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option
                                                            {{ Request::get('subject_id') == $subject->id ? 'selected' : '' }}
                                                            value="{{ $subject->id }}">{{ $subject->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="attendance_type">Điểm danh</label>
                                            <select id="attendance_type" class="form-control " name="attendance_type">
                                                <option value="">----Tất cả----</option>


                                                <option {{ Request::get('attendance_type') == '1' ? 'selected' : '' }}
                                                    value="1">Có </option>
                                                <option {{ Request::get('attendance_type') == '2' ? 'selected' : '' }}
                                                    value="2">Muộn </option>
                                                <option {{ Request::get('attendance_type') == '3' ? 'selected' : '' }}
                                                    value="3">Phép </option>
                                                <option {{ Request::get('attendance_type') == '4' ? 'selected' : '' }}
                                                    value="4">Vắng </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="attendance_date">Ngày điểm danh</label>
                                            <input id="getAttendanceDate" value="{{ Request::get('attendance_date') }}"
                                                type="date" name="attendance_date" class="form-control" required />

                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                kiếm</button>
                                            <a href="{{ url('admin/attendance/report') }}" class="btn btn-success"
                                                style="margin-top:30px;">Làm mới</a>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="card">

                            <div class="card-header">
                                Điểm danh

                            </div>
                            <div style="overflow-x: auto;" class="card-body p-0">
                                @if (empty($noUseTools))
                                    <div id="tools"></div>
                                @endif
                                <table id="tableList" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Học sinh</th>
                                            <th>Lớp</th>
                                            <th>Môn học</th>
                                            <th>Điểm danh</th>
                                            <th>Ngày điểm danh</th>
                                            <th>Người tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->student_name }} {{ $value->student_last_name }}</td>
                                                <td>{{ $value->class_name }} </td>
                                                <td>{{ $value->subject_name }} </td>
                                                <td>
                                                    @if ($value->attendance_type == 1)
                                                        Có
                                                    @elseif($value->attendance_type == 2)
                                                        Muộn
                                                    @elseif($value->attendance_type == 2)
                                                        Phép
                                                    @else
                                                        Vắng
                                                    @endif

                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($value->attendance_date)) }}</td>
                                                <td>{{ $value->created_by_name }} {{ $value->created_by_last_name }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%">Chưa có báo cáo.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div style="padding: 10px; float: right;">{!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>
                            </div>
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
    <script type="text/javascript"></script>
@endsection
