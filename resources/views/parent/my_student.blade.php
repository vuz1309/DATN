  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Con của tôi</h1>
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

       
         
         <div class="card">
             <div class="card-header">Con cái</div>
            <!-- /.card-header -->
            <div class="card-body p-0" style="overflow: auto;">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Ảnh</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                   
                    <th>Admission number</th>
                    <th>Roll number</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Khối</th>
                    <th>Tôn giáo</th>
                    <th>Chiều cao (kg)</th>
                    <th>Cân nặng (kg)</th>
                    <th>Trạng thái</th>
                    <th></th>
                    <th></th>
                    <th></th>
                   
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
                     
                      <td>{{$value->admission_number}} </td>
                      <td>{{$value->roll_number}} </td>
                      <td>{{$value->class_name}} </td>
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
                      <td>{{$value->caste}} </td>
                      <td>{{$value->religion}} </td>
                      <td>{{$value->height}} </td>
                      <td>{{$value->weight}} </td>

                      <td>
                      @if($value->status == 0)
                      Đang hoạt động
                      @else
                      Ngưng hoạt động
                      @endif
                      </td>
                      <td>
                        <a class="btn btn-primary" href="{{url('parent/my_student/subject/' .$value->id)}}">Môn học</a>
                      </td>
                      <td>
                        <a class="btn btn-warning" href="{{url('parent/my_student/exam_schedule/' .$value->id)}}">Lịch thi</a>
                      </td>
                      <td>
                        <a class="btn btn-success" href="{{url('parent/my_student/calendar/' .$value->id)}}">Lịch học</a>
                      </td>
                    </tr>
                  @endforeach
                    
                 
                </tbody>
              </table>

              <div style="padding: 10px; float: right;"></div>
            </div>
            <!-- /.card-body -->
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