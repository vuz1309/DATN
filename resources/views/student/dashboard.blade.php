@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->



    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">Tổng quan</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>



        <section class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ number_format($getTotalFees) }} đ</h3>

                                <p>Học phí đã nộp</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ url('student/fee_collect') }}" class="small-box-footer">Chi tiết <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div>
                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $TotalHomework }}</h3>

                                <p>Bài tập</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('student/my_homework') }}" class="small-box-footer">Xem thêm <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div>
                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $TotalHomeworkSubmitted }}</h3>

                                <p>Bài tập đã nộp</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('student/homework/submitted') }}" class="small-box-footer">Xem thêm <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $TotalSubject }}</h3>

                                <p>Môn học</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('student/my_subject') }}" class="small-box-footer">Xem thêm <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div>


                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
