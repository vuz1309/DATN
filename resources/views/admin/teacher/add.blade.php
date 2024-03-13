  
@extends('layouts.app')
   
   @section('content')
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thêm mới giáo viên</h1>
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
         
          <div class="card card-primary">
             
              <!-- form start -->
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field()}}
                <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6">
                      <label for="name">Họ <span style="color:red;">*</span></label>
                      <input name="name" value="{{old('name')}}"  type="text" required class="form-control" id="name" placeholder="">
                      <div style="color: red;">{{$errors->first('name')}}</div>

                  </div>
                  <div class="form-group col-md-6">
                      <label for="last_name">Tên <span style="color:red;">*</span></label>
                      <input name="last_name" value="{{old('last_name')}}"  type="text" required class="form-control" id="last_name" placeholder="">
                      <div style="color: red;">{{$errors->first('last_name')}}</div>

                  </div>
                
                
                 
                
                
                  
                  <div class="form-group col-md-6">
                      <label for="gender">Giới tính</label>
                      <select class="form-control"   name="gender">
                       
                        <option {{ old('gender') == '1' ? 'selected' : '' }} value="1">Nam</option>
                        <option {{ old('gender') == '2' ? 'selected' : '' }}  value="2">Nữ</option>
                        <option {{ old('gender') == '3' ? 'selected' : '' }}  value="3">Khác</option>
                      </select>
                      <div style="color: red;">{{$errors->first('gender')}}</div>

                  </div>

                  
                
                  <div class="form-group col-md-6">
                      <label for="date_of_birth">Ngày sinh</label>
                      <input value="{{old('date_of_birth')}}" name="date_of_birth"  type="date"  class="form-control" id="date_of_birth" placeholder="">
                      <div style="color: red;">{{$errors->first('date_of_birth')}}</div>

                  </div>

                  <div class="form-group col-md-6">
                      <label for="religion">Tôn giáo</label>
                      <input value="{{old('religion')}}" name="religion"  type="text"  class="form-control" id="religion" placeholder="">
                      <div style="color: red;">{{$errors->first('religion')}}</div>


                  </div>

                  <div class="form-group col-md-6">
                      <label for="mobile_number">Số điện thoại</label>
                      <input value="{{old('mobile_number')}}" name="mobile_number"  type="text"  class="form-control" id="mobile_number" placeholder="">
                      <div style="color: red;">{{$errors->first('mobile_number')}}</div>

                  </div>

                  <div class="form-group col-md-6">
                      <label for="admission_date">Ngày vào trường</label>
                      <input value="{{old('admission_date')}}" name="admission_date"  type="date"  class="form-control" id="admission_date" placeholder="">
                      <div style="color: red;">{{$errors->first('admission_date')}}</div>

                  </div>

                  <div class="form-group col-md-6">
                      <label for="profile_pic">Ảnh</label>
                      <input value="{{old('profile_pic')}}" name="profile_pic"  type="file"  class="form-control" id="profile_pic" placeholder="">
                      <div style="color: red;">{{$errors->first('profile_pic')}}</div>

                  </div>

                  <div class="form-group col-md-6">
                      <label for="address">Địa chỉ</label>
                      <textarea value="{{old('address')}}" name="address"  type="text"  class="form-control" id="address" placeholder=""> </textarea>
                      <div style="color: red;">{{$errors->first('address')}}</div>

                  </div>
                  <div class="form-group col-md-6">
                    <label for="permanent_address">Địa chỉ thường trú</label>
                    <textarea value="{{old('permanent_address')}}" name="permanent_address"  type="text"  class="form-control" id="permanent_address" placeholder=""> </textarea>
                    <div style="color: red;">{{$errors->first('permanent_address')}}</div>

                </div>
                  <div class="form-group col-md-6">
                    <label for="qualification">Chuyên môn</label>
                    <textarea value="{{old('qualification')}}" name="qualification"  type="text"  class="form-control" id="qualification" placeholder="" > </textarea>
                    <div style="color: red;">{{$errors->first('qualification')}}</div>

                </div>
                  <div class="form-group col-md-6">
                      <label for="work_experience">Kinh nghiệm</label>
                      <textarea value="{{old('work_experience')}}" name="work_experience"  type="text"  class="form-control" id="work_experience" placeholder=""></textarea>
                      <div style="color: red;">{{$errors->first('work_experience')}}</div>

                  </div>

                  <div class="form-group col-md-6">
                      <label for="note">Ghi chú</label>
                      <textarea value="{{old('note')}}" name="note"  type="text"  class="form-control" id="note" placeholder=""> </textarea>
                      <div style="color: red;">{{$errors->first('note')}}</div>

                  </div>

                 
                  <div class="form-group col-md-6">
                      <label for="status">Trạng thái <span style="color: red;">*</span></label>
                      <select class="form-control"   name="status">
                       
                        <option  value="0">Đang sử dụng</option>
                        <option value="1">Ngưng sử dụng</option>
                       
                      </select>
                  </div>

                  </div>
                  


                <div class="form-group col-md-12">
                      <label for="email">Email <span style="color: red;">*</span></label>
                      <input value="{{old('email')}}" name="email"  type="email" required class="form-control" id="email" placeholder="">

                      <div style="color: red;">{{$errors->first('email')}}</div>
                  </div>

                  <div class="form-group col-md-12">
                      <label for="password">Mật khẩu đăng nhập <span style="color: red;">*</span></label>
                      <input value="{{old('password')}}" name="password"  type="password" required class="form-control" id="password" placeholder="">
                  </div>
              
                
                </div>
                
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm mới</button>
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