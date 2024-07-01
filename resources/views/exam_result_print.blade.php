<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>In kết quả</title>
    <style>
        @page {
            size: 8.3in 11.7in;
        }

        @page {
            size: A4
        }

        .margin-bottom: {
            margin-bottom: 3px;
        }

        @media print {
            @page {
                margin: 0px;
                margin-left: 20px;
                margin-right: 20px;
            }
        }

        .table-bg {
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            text-align: center;
            margin-top: 32px;
        }

        .table-bg th {
            border: 1px solid #000;
            padding: 10px;
        }

        .table-bg td {

            border: 1px solid #000;
            padding: 3px;
        }
    </style>
</head>

<body>
    <div id="page">
        <table>
            <tr>

                <td width="5%"></td>
                <td width="15%">
                    @php
                        $logo = config('app.system_settings.school_logo');
                    @endphp
                    @if (!empty($logo))
                        <img src="{{ url('upload/settings/' . $logo) }}"
                            style="width: 110px; height: 110px; border-radius: 50%" alt="LOGO">
                    @else
                        <img style="width: 110px;"
                            src="https://png.pngtree.com/png-clipart/20211017/original/pngtree-school-logo-png-image_6851480.png"
                            alt="">
                    @endif

                </td>
                <td align="left">
                    <h1>VSHOOL <br />{{ config('app.system_settings.school_name') }}</h1>
                </td>
                <td></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="27%">Tên học sinh: </td>
                                <td style="border-bottom: 1px solid #000; width: 100%"> {{ $getStudent->name }}
                                    {{ $getStudent->last_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="27%">Mã học sinh: </td>
                                <td style="border-bottom: 1px solid #000; width: 100%">
                                    {{ $getStudent->admission_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="27%">Lớp: </td>
                                <td style="border-bottom: 1px solid #000; width: 100%">{{ $getClass->name }} </td>
                            </tr>
                        </tbody>
                    </table> --}}
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>

                                <td width="27%">Kì thi: </td>
                                <td style="border-bottom: 1px solid #000; width: 80%"> {{ $exam_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>


            </tr>


        </table>
        <div>
            <table class="table-bg">
                <thead>
                    <tr>

                        <th>Khóa học</th>
                        <th>Tổng điểm</th>
                        <th>Điểm đạt</th>
                        <th>Tổng kết</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($getExamMark as $exam)
                        <tr>
                            <td>{{ $exam['subject_name'] }}</td>
                            <td style="text-align: center;">{{ $exam['total'] }}</td>
                            <td style="text-align: center;">{{ $exam['passing_mark'] }} /
                                {{ $exam['full_marks'] }}</td>

                            <td style="text-align: center;">{{ $exam['grade'] }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>

        </div>

        <table class="margin-bottom" style="width: 100%; margin-top: 32px;">
            <tbody>
                <tr>
                    <td width="27%">Chữ kí giáo viên: </td>

                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000; width: 27%"> </td>
                </tr>
            </tbody>
        </table>



    </div>
    <script type="text/javascript">
        window.print()
    </script>
</body>

</html>
