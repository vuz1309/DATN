  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Lớp học - môn học (Tổng: {{$getRecord->total()}})</h1>
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
         <!-- /.card -->
          <div class="card-header">Tìm kiếm</div>
         <div class="card card-primary">
          
           <!-- form start -->
           <form method="get" action="">
           
             <div class="card-body">
             <div class="row">
               <div class="form-group col-md-3">
                   <label for="subject_name">Tên môn học</label>
                   <input name="subject_name" value="{{Request::get('subject_name')}}" type="text" class="form-control" id="subject_name" placeholder="">
                 </div>

                 <div class="form-group col-md-3">
                   <label for="class_name">Tên lớp học</label>
                   <input name="class_name" value="{{Request::get('class_name')}}" type="text" class="form-control" id="class_name" placeholder="">
                 </div>
               
                 <div class="form-group col-md-3">
                   <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm kiếm</button>
                   <a href="{{url("teacher/my_class_subject")}}" class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                 </div>
             </div>
             </div>

           </form>
         </div>
      

         <div class="card">
          <div class="card-header">Lớp học - môn học</div>
           <!-- /.card-header -->
           <div class="card-body p-0">
             <table class="table table-striped">
               <thead>
                 <tr>
                   <th>Lớp học</th>
                   <th>Môn học</th>
                   <th>Lịch hôm nay</th>
                   <th>Thể loại</th>
                   <th></th>
                 </tr>
               </thead>
               <tbody>
                 @foreach ($getRecord as $value)
                   <tr>
                     <td>{{$value->class_name}}</td>
                     <td>{{$value->subject_name}}</td>
                     
                     <td>
                     
                      @if(!empty($value->timeable))
                      <div>{{date('H:i A', strtotime($value->timeable->start_time)) }} - {{date('H:i A', strtotime($value->timeable->end_time))}}</div>
                      <div>Phòng: {{$value->timeable->room_number}}</div>
                      @endif
                     </td>
                     <td>{{$value->subject_type}}</td>
                     <td> 
                        <a class="btn btn-primary" href="{{url('teacher/my_class_subject/timeable/' .$value->subject_id . '/' .$value->class_id )}}">Thời khóa biểu</a>
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