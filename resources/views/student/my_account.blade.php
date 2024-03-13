  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Cập nhật thông tin</h1>
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
      
       <div class="card card-primary">
          
           <!-- form start -->
           <form method="post" action="" enctype="multipart/form-data">
             {{ csrf_field()}}
             <div class="card-body">
             <div class="row">
               <div class="form-group col-md-6">
                   <label for="name">Họ <span style="color:red;">*</span></label>
                   <input name="name" value="{{$getRecord->name}}"   type="text" required class="form-control" id="name" placeholder="">
                   <div style="color: red;">{{$errors->first('name')}}</div>

               </div>
               <div class="form-group col-md-6">
                   <label for="last_name">Tên <span style="color:red;">*</span></label>
                   <input name="last_name" value="{{$getRecord->last_name}}"   type="text" required class="form-control" id="last_name" placeholder="">
                   <div style="color: red;">{{$errors->first('last_name')}}</div>

               </div>
             
             
               <div class="form-group col-md-6">
                   <label for="admission_number">Mã học sinh <span style="color:red;">*</span></label>
                   <input readonly name="admission_number" value="{{$getRecord->admission_number}}"   type="text" required class="form-control" id="admission_number" placeholder="">
                   <div style="color: red;">{{$errors->first('admission_number')}}</div>

               </div>
               <div class="form-group col-md-6">
                   <label for="roll_number">Roll number </label>
                   <input  name="roll_number" value="{{$getRecord->roll_number}}"  type="text"  class="form-control" id="roll_number" placeholder="">
                   <div style="color: red;">{{$errors->first('roll_number')}}</div>
               </div>
            
             
               <div class="form-group col-md-6">
                   <label for="class_id">Lớp <span style="color:red;">*</span></label>
                   <select readonly class="form-control"  required name="class_id">
                   <option value="">Chọn lớp học</option>
                   @foreach ($getClass as $class)

                   <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }} value="{{$class->id}}">{{$class->name}}</option>

                     
                   @endforeach
                   </select>
               </div>
               
               <div class="form-group col-md-6">
                   <label for="gender">Giới tính</label>
                   <select class="form-control"   name="gender">
                     
                     <option {{$getRecord->gender == '1' ? 'selected' : '' }} value="1">Nam</option>
                     <option {{ $getRecord->gender == '2' ? 'selected' : '' }}  value="2">Nữ</option>
                     <option {{ $getRecord->gender == '3' ? 'selected' : '' }}  value="3">Khác</option>
                   </select>
                   <div style="color: red;">{{$errors->first('gender')}}</div>

               </div>

               
             
               <div class="form-group col-md-6">
                   <label for="date_of_birth">Ngày sinh</label>
                   <input  name="date_of_birth" value="{{$getRecord->date_of_birth}}"  type="date"  class="form-control" id="date_of_birth" placeholder="">
                   <div style="color: red;">{{$errors->first('date_of_birth')}}</div>

               </div>

               <div class="form-group col-md-6">
                   <label for="caste">Khối <span style="color: red;">*</span></label>
                   <input  name="caste" value="{{$getRecord->caste}}"  type="text" required class="form-control" id="caste" placeholder="">
                   <div style="color: red;">{{$errors->first('caste')}}</div>

               </div>
               <div class="form-group col-md-6">
                   <label for="religion">Tôn giáo</label>
                   <input  name="religion" value="{{$getRecord->religion}}"  type="text"  class="form-control" id="religion" placeholder="">
                   <div style="color: red;">{{$errors->first('religion')}}</div>


               </div>

               <div class="form-group col-md-6">
                   <label for="mobile_number">Số điện thoại</label>
                   <input  name="mobile_number" value="{{$getRecord->mobile_number}}"  type="text"  class="form-control" id="mobile_number" placeholder="">
                   <div style="color: red;">{{$errors->first('mobile_number')}}</div>

               </div>

               <div class="form-group col-md-6">
                   <label for="admission_date">Ngày nhập học</label>
                   <input  name="admission_date" value="{{$getRecord->admission_date}}"  type="date"  class="form-control" id="admission_date" placeholder="">
                   <div style="color: red;">{{$errors->first('admission_date')}}</div>

               </div>

               <div class="form-group col-md-6">
                   <label for="profile_pic">Ảnh học sinh</label>
                   <input  name="profile_pic" value="{{$getRecord->profile_pic}}"  type="file"  class="form-control" id="profile_pic" placeholder="">
                   <div style="color: red;">{{$errors->first('profile_pic')}}</div>
                   @if (!empty($getRecord->profile_pic))

                   <img src="{{ $getRecord->getProfile() }}" style="width: auto; height:50px;" />
                     
                   @endif

               </div>

               <div class="form-group col-md-6">
                   <label for="blood_group">Nhóm máu</label>
                   <input  name="blood_group" value="{{$getRecord->blood_group}}"  type="text"  class="form-control" id="blood_group" placeholder="">
                   <div style="color: red;">{{$errors->first('blood_group')}}</div>

               </div>

               <div class="form-group col-md-6">
                   <label for="weight">Cân nặng</label>
                   <input  name="weight" value="{{$getRecord->weight}}"  type="text"  class="form-control" id="weight" placeholder="">
                   <div style="color: red;">{{$errors->first('weight')}}</div>

               </div>

               <div class="form-group col-md-6">
                   <label for="height">Chiều cao</label>
                   <input  name="height" value="{{$getRecord->height}}"  type="text"  class="form-control" id="height" placeholder="">
                   <div style="color: red;">{{$errors->first('height')}}</div>

               </div>

              
               <div class="form-group col-md-6">
                   <label for="status">Trạng thái <span style="color: red;">*</span></label>
                   <select class="form-control"   name="status">
                     
                     <option  {{$getRecord->status == '0' ? 'selected' : ''}} value="0">Đang học</option>
                     <option {{$getRecord->status == '1' ? 'selected' : ''}}  value="1">Ngưng học tập</option>
                    
                   </select>
               </div>

               </div>
               


             <div class="form-group col-md-12">
                   <label for="email">Email <span style="color: red;">*</span></label>
                   <input  name="email" value="{{$getRecord->email}}"  type="email" required class="form-control" id="email" placeholder="">

                   <div style="color: red;">{{$errors->first('email')}}</div>
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