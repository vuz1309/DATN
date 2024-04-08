  
@extends('layouts.app')
   
   @section('content')
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Đổi mật khẩu</h1>
          </div>
          <!-- <div class="col-sm-6" style="text-align: right;">
            <a href="{{ url('admin/dashboard') }}"></a>
          </div> -->
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
         
          <div class="card card-primary">
             
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field()}}
                <div class="card-body">
                <div class="form-group">
                    <label for="old_password">Mật khẩu cũ </label>
                    <input name="old_password"  type="password" required class="form-control" id="old_password" placeholder="">
                  </div>
                  
                  <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input name="new_password"  type="password" required class="form-control" id="new_password" placeholder="">
                  </div>

                  <div class="form-group">
                    <label for="confirm_new_password">Nhập lại mật khẩu mới</label>
                    <input name="confirm_new_password"  type="password" required class="form-control" id="confirm_new_password" placeholder="">
                  </div>
                  
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
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