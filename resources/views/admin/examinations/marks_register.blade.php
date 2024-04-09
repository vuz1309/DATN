  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Điểm</h1>
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

         <div class="card card-primary">
          
           <!-- form start -->
           <form method="get" action="">
            <div class="card-header">Tìm kiếm</div>
           
             <div class="card-body">
             <div class="row">
                 <div class="form-group col-md-3">
                   <label for="exam_id">Kì thi</label>
                   <select class="form-control getExam" name="exam_id">
                    <option value="">Chọn kì thi</option>
                    @if(!empty($getExam))
                      @foreach ($getExam as $exam)
                      <option {{ Request::get('exam_id') == $exam->id ? 'selected' : '' }} value="{{$exam->id}}">{{$exam->name}}</option>
                      @endforeach
                    @endif
                    </select>
                 </div>

                 <div class="form-group col-md-3">
                    <label for="class_id">Lớp học</label>
                    <select class="form-control getClass" name="class_id">
                      <option value="">Chọn lớp học</option>
                      @if(!empty($getClass))
                        @foreach ($getClass as $class)
                        <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }} value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                      @endif
                      </select>
 
                  </div>


                 <div class="form-group col-md-3">
                   <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm kiếm</button>
                   <a href="{{url("admin/examinations/marks_register")}}" class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                 </div>

             </div> 
             </div>
           </form>
         </div>
       
         @if(!empty($getSubject) && !empty($getSubject->count()))
        <div class="card">
                
            <div class="card-header"><h3>Lịch thi</h3></div>
            <div style="overflow-x: auto;" class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Học sinh</th>
                    @foreach ($getSubject as $subject )
                        <th>{{ $subject->subject_name }} <br/>
                         ({{ $subject->subject_type }} {{ $subject->passing_mark }} / {{ $subject->full_marks }})</th>
                    @endforeach
                   <th></th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($getStudent) && !empty($getStudent->count()))
                   
                    
                    @foreach ($getStudent as  $student)
                        <form name="post" class="SubmitForm" >
                        {{ csrf_field() }}
                        <tr>
                            <input type="hidden" name="student_id" value="{{$student->id}}" />
                            <input type="hidden" name="exam_id" value="{{Request::get('exam_id')}}" />
                            <input type="hidden" name="class_id" value="{{Request::get('class_id')}}" />
                            <td>
                                {{ $student->name }} {{ $student->last_name }}
                            </td>
                            @php
                                $id = 1;
                            @endphp
                            @foreach ($getSubject as $subject )
                            @php
                                $getMark = $subject->getmark($student->id,Request::get('exam_id'),  Request::get('class_id'), $subject->subject_id);
                            @endphp
                            <td>
                               <div style="margin-bottom: 10px;">
                                    Điểm trên lớp
                                    <input style="width: 200px;" type="hidden" value="{{$subject->subject_id}}" name="mark[{{$id}}][subject_id]" class="form-control" />
                                    <input value="{{ !empty($getMark) ? $getMark->class_work : ''}}" style="width: 200px;" type="text" name="mark[{{$id}}][class_work]" class="form-control" />
                               </div>
                               <div style="margin-bottom: 10px;">
                                Điểm về nhà
                                <input value="{{ !empty($getMark) ? $getMark->home_work : ''}}" style="width: 200px;"  type="text" name="mark[{{$id}}][home_work]" class="form-control" />
                            </div>
                            <div style="margin-bottom: 10px;">
                                Điểm kiểm tra
                                <input value="{{ !empty($getMark) ? $getMark->test_work : ''}}"  style="width: 200px;"  type="text" name="mark[{{$id}}][test_work]" class="form-control" />
                            <div style="margin-bottom: 10px;">
                                Điểm thi
                                <input value="{{ !empty($getMark) ? $getMark->exam : ''}}"  style="width: 200px;"  type="text" name="mark[{{$id}}][exam]" class="form-control" />
                       </div>
                            </td>
                            @php
                                $id++;
                            @endphp
                            @endforeach
                            <td>
                                <button class="btn btn-success">Lưu</button>
                            </td>
                        </tr>
                        </form>
                    @endforeach
                
                    @endif
                </tbody>
            </table>
            </div>
            </div>
       
       </div>
        @endif
       <!-- /.col -->
     </div>
     <!-- /.row -->
     
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </section>
 <!-- /.content -->
</div>

@endsection


@section('script')

<script type="text/javascript">
    $('.SubmitForm').submit(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "{{url('admin/examinations/submit_marks_register')}}",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                alert(data.message);
            },

        })
    })
</script>

@endsection


