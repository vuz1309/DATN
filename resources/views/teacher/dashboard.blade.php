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

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $TotalStudent }}</h3>

                                <p>Học sinh</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ url('vTeacher/my_student') }}" class="small-box-footer">Xem thêm <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div>


                    {{-- <div class="col-lg-3 col-6">

                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $TotalClass }}</h3>

                                <p>Lớp</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-grid"></i>
                            </div>
                            <a href="{{ url('vTeacher/class/list') }}" class="small-box-footer">Xem thêm <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>

                    </div> --}}
                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $TotalSubject }}</h3>

                                <p>Khóa học</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('vTeacher/my_class_subject') }}" class="small-box-footer">Xem thêm <i
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
