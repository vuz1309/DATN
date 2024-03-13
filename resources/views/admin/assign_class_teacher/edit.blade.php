  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Thêm giáo viên - lớp học</h1>
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
      @include('_message')
       <div class="card card-primary">
          
           <!-- form start -->
           <form method="post" action="">
             {{ csrf_field()}}
             <div class="card-body">
              <div class="form-group">
                <label>Lớp học</label>
                <select name="class_id" class="form-control">
                  @foreach ($getClass as $class)

                  <option {{ $getRecord->class_id == $class->id ? 'selected' : ''}} value="{{$class->id}}">{{$class->name}}</option>
                    
                  @endforeach
                </select>
              </div>
          
              <div class="form-group">
                <label>Giáo viên</label>
                
                  @foreach ($getTeachers as $teacher)
                    @php

                    $checked = "";
                    @endphp

                    @foreach ($getAssignTeacherID as $teacherAssign)
                      @if($teacherAssign->teacher_id == $teacher->id)
                      @php
                      $checked = "checked"
                      @endphp
                      @endif
                    @endforeach
                  
              <div>
                <label style="font-weight:700;">
                       <input {{ $checked }}  name="teacher_id[]" type="checkbox" value="{{$teacher->id}}">{{$teacher->name}} {{$teacher->last_name}}</input>
                       </label>
              </div>
                    
                  @endforeach
                
              </div>
             
               
               <div class="form-group">
                 <label>Trạng thái</label>
                 <select name="status" class="form-control">
                  <option value="0">Hoạt động</option>
                  <option value="1">Ngưng hoạt động</option>
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