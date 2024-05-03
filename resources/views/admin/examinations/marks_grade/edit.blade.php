@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm mới thang điểm</h1>
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
                            <form method="post" action="">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <input name="id" type="hidden" value="{{ $getRecord->id }}" required
                                        class="form-control" id="id" value="{{ $getRecord->name }}" placeholder="">
                                    <div class="form-group">
                                        <label for="name">Tên<span style="color: red;">*</span></label>
                                        <input name="name" type="text" required class="form-control" id="name"
                                            value="{{ $getRecord->name }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="percent_from">Điểm từ<span style="color: red;">*</span></label>
                                        <input value="{{ $getRecord->percent_from }}" name="percent_from" type="number"
                                            required step="0.01" class="form-control" id="percent_from" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="percent_to">Điểm đến<span style="color: red;">*</span></label>
                                        <input value="{{ $getRecord->percent_to }}" name="percent_to" step="0.01"
                                            type="number" required class="form-control" id="percent_to" placeholder="">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </div>
                            </form>
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
