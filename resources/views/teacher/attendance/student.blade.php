@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Điểm danh</h1>
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
                                            <label for="subject_id">Khóa học</label>
                                            <select id="getSubject" class="form-control getSubject" name="subject_id">
                                                <option value="">----Chọn----</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option
                                                            {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}
                                                            value="{{ $subject->subject_id }}">{{ $subject->subject_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="attendance_date">Ngày điểm danh</label>
                                            <input id="getAttendanceDate"
                                                value="{{ !empty(Request::get('attendance_date')) ? Request::get('attendance_date') : date('Y-m-d') }}"
                                                type="date" name="attendance_date" class="form-control" required />

                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm
                                                kiếm</button>
                                            <a href="{{ url('vAdmin/attendance/student') }}" class="btn btn-success"
                                                style="margin-top:30px;">Làm mới</a>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="card">

                            <div class="card-header">
                                Điểm danh - @if (!empty($getSubjectAttendance))
                                    Môn: <b>{{ $getSubjectAttendance->name }}</b>
                                @endif
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
                                            <th>Điểm danh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (
                                            !empty($getStudent) &&
                                                !empty(Request::get('subject_id')) &&
                                                !empty(Request::get('class_id')) &&
                                                !empty(Request::get('attendance_date')))
                                            @foreach ($getStudent as $student)
                                                @php
                                                    $attendance_type = null;
                                                    $getAttendance = $student->getAttendance(
                                                        $student->id,
                                                        Request::get('class_id'),
                                                        Request::get('subject_id'),
                                                        Request::get('attendance_date'),
                                                    );
                                                    if (!empty($getAttendance)) {
                                                        $attendance_type = $getAttendance->attendance_type;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $student->id }}</td>
                                                    <td>{{ $student->name }} {{ $student->last_name }}</td>
                                                    <td>
                                                        <label style="margin-right: 8px">
                                                            <input class="SaveAttendance"
                                                                data-class="{{ Request::get('class_id') }}"
                                                                id="{{ $student->id }}" value="1" type="radio"
                                                                {{ $attendance_type == '1' || $attendance_type == null ? 'checked' : '' }}
                                                                name="attendance{{ $student->id }}" />
                                                            Có</label>
                                                        <label style="margin-right: 8px">
                                                            <input id="{{ $student->id }}" value="2"
                                                                {{ $attendance_type == '2' ? 'checked' : '' }}
                                                                class="SaveAttendance"
                                                                data-class="{{ Request::get('class_id') }}" type="radio"
                                                                name="attendance{{ $student->id }}" />
                                                            Muộn</label>
                                                        <label style="margin-right: 8px">
                                                            <input id="{{ $student->id }}" value="3"
                                                                {{ $attendance_type == '3' ? 'checked' : '' }}
                                                                class="SaveAttendance"
                                                                data-class="{{ Request::get('class_id') }}" type="radio"
                                                                name="attendance{{ $student->id }}" />
                                                            Phép</label>
                                                        <label style="margin-right: 8px">
                                                            <input id="{{ $student->id }}" value="4"
                                                                {{ $attendance_type == '4' ? 'checked' : '' }}
                                                                class="SaveAttendance"
                                                                data-class="{{ Request::get('class_id') }}" type="radio"
                                                                name="attendance{{ $student->id }}" />
                                                            Nghỉ</label>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td rowspan="10">Không có học sinh <br /> <span
                                                        style="font-style: italic">(Vui lòng chọn đầy đủ lớp, Khóa học, ngày
                                                        điểm danh)</span> </td>
                                                <td>

                                                </td>
                                                <td></td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
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
    <script type="text/javascript">
        $('.getClass').change(function() {
            const class_id = $(this).val();
            $.ajax({
                url: "{{ url('vAdmin/class_timeable/get_subject') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_id,
                },
                dataType: "json",
                success: function(response) {
                    console.log('ntvu:', response.html);
                    $('.getSubject').html(response.html);
                }
            })
        });

        $('.SaveAttendance').change(function() {
            const class_id = $('#getClass').val();
            const subject_id = $('#getSubject').val();
            const attendance_date = $('#getAttendanceDate').val();
            const student_id = $(this).attr('id');
            const attendance_type = $(this).val();
            $.ajax({
                url: "{{ url('vAdmin/attendance/student') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id,
                    subject_id,
                    attendance_date,
                    student_id,
                    attendance_type
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                }
            })
        });
    </script>
@endsection
