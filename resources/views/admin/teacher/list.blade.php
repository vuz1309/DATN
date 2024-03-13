  
@extends('layouts.app')
   
   @section('content')
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách học sinh (Tổng: {{$getRecord->total()}})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <a class="btn btn-primary" href="{{ url('admin/teacher/add') }}">Thêm mới</a>
          </div>
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
         
            <!-- /.card -->

            <div class="card card-primary">
             
              <!-- form start -->
              <form method="get" action="">
             <div class="card-header">Tìm kiếm</div>
              
                <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-3">
                      <label for="name">Tên</label>
                      <input name="name" value="{{Request::get('name')}}" type="text" class="form-control" id="name" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="email">Email</label>
                      <input name="email" value="{{Request::get('email')}}" type="text" class="form-control" id="email" placeholder="">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="gender">Giới tính</label>
                      <select class="form-control"   name="gender">
                        <option {{ empty(Request::get('gender')) ? 'selected' : '' }}  value="">Tất cả</option>
                        <option {{ Request::get('gender') == '1' ? 'selected' : '' }} value="1">Nam</option>
                        <option {{ Request::get('gender') == '2' ? 'selected' : '' }}  value="2">Nữ</option>
                        <option {{ Request::get('gender') == '3' ? 'selected' : '' }}  value="3">Khác</option>
                          
                        
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="mobile_number">Điện thoại</label>
                      <input name="mobile_number" value="{{Request::get('mobile_number')}}" type="text" class="form-control" id="mobile_number" placeholder="">
                    </div>


                    <div class="form-group col-md-3">
                      <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm kiếm</button>
                      <a href="{{url("admin/teacher/list")}}" class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                    </div>

                </div>
                  
                  
                </div>

              </form>
            </div>
         

            <div class="card">
             <div class="card-header">Giáo viên</div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Ảnh</th>
                      <th>Họ tên</th>
                      <th>Email</th>
                      <th>Điện thoại</th>
                      <th>Ngày vào trường</th>
                      <th>Ngày sinh</th>
                      <th>Giới tính</th>
                      
                     
                      <th>Trạng thái</th>
                      
                      <th>Ngày tạo</th>
                      <th style="min-width: 160px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $value)
                      <tr>
                        <td>{{$value->id}}</td>
                        <td>
                          @if (!empty($value->profile_pic))
                          <img style="width: 50px; height: 50px; border-radius: 50%" src="{{url('upload/profile/'.$value->profile_pic)}}" />
                          @endif</td>
                        <td>{{$value->name}} {{ $value->last_name}}</td>
                        <td>{{$value->email}} </td>
                        <td>{{$value->mobile_number}} </td>
                        <td> @if(!@empty($value->addmission_date))
                          {{date('d-m-Y', strtotime($value->addmission_date))}}

                      @endif   </td>
                        <td> @if(!@empty($value->date_of_birth))
                            {{date('d-m-Y', strtotime($value->date_of_birth))}}

                        @endif   </td>
                       
                        <td> 
                            @if($value->gender == 1)
                        Nam
                        @elseif($value->gender == 2)
                        Nữ
                        @elseif($value->gender == 3)
                        Khác
                        @endif 
                        </td>


                        <td>
                          @if($value->status == 0)
                          Đang hoạt động
                          @else
                          Ngưng hoạt động
                          @endif
                          </td>
                       
                        <td>{{ date('d-m-Y H:m', strtotime($value->created_at))}}</td>
                        <td>
                          <a href="{{url('admin/teacher/edit/' . $value->id)}}" class="btn btn-primary">Sửa</a>
                          <a href="{{url('admin/teacher/delete/' . $value->id)}}" class="btn btn-danger">Xóa</a>
                        </td>

                       
                      </tr>
                    @endforeach
                      
                   
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