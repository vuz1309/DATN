  
@extends('layouts.app')
   
   @section('content')
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thêm mới lớp học</h1>
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
 
          <!-- /.col -->
          <div class="col-md-12">
         
          <div class="card card-primary">
             
              <!-- form start -->
              <form method="post" action="">
                {{ csrf_field()}}
                <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên lớp</label>
                    <input name="name"  type="text" value="{{$getRecord->name}}" class="form-control" id="name" placeholder="">
                  </div>
                  <div class="form-group">
                    <label >Trạng thái</label>
                    <select name="status" class="form-control">
                        <option {{$getRecord->status == 0 ? 'selected' : '' }} value="0">Đang hoạt động</option>
                        <option  {{$getRecord->status == 1 ? 'selected' : '' }} value="1">Ngừng hoạt động</option>
                    </select>
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