  
@extends('layouts.app')
   
   @section('content')
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sửa gán môn học cho lớp</h1>
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
                    <label>Lớp học</label>
                    <select name="class_id" class="form-control">
                      @foreach ($getClass as $class)

                      <option {{ $getRecord->class_id == $class->id ? 'selected' : ''}} value="{{$class->id}}">{{$class->name}}</option>
                        
                      @endforeach
                    </select>
                  </div>
              
                  <div class="form-group">
                    <label>Môn học</label>
                    
                      @foreach ($getSubject as $subject)
                        @php

                        $checked = "";
                        @endphp

                        @foreach ($getAssignSubjectID as $subjectAssign)
                          @if($subjectAssign->subject_id == $subject->id)
                          @php
                          $checked = "checked"
                          @endphp
                          @endif
                        @endforeach
                      
                  <div>
                    <label style="font-weight:700;">
                           <input {{ $checked }}  name="subject_id[]" type="checkbox" value="{{$subject->id}}">{{$subject->name}}</input>
                           </label>
                  </div>
                        
                      @endforeach
                    
                  </div>
                
                  
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                     <option {{ $getRecord->status == '0' ? 'selected' : ''}} value="0">Hoạt động</option>
                     <option {{ $getRecord->status == '1' ? 'selected' : ''}} value="1">Ngưng hoạt động</option>
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