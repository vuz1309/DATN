  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Thời khóa biểu</h1>
       </div>
     </div>
     <div class="col-sm-6" style="text-align: right;">
        <a class="btn btn-primary" href="{{ url('admin/class_timeable/add') }}">Thêm mới</a>
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
            <div class="card-header">Tạo</div>
           
             <div class="card-body">
             <div class="row">
                 <div class="form-group col-md-3">
                   <label for="class_id">Lớp</label>
                   <select class="form-control getClass" required name="class_id">
                     <option value="">Chọn lớp học</option>
                     @foreach ($getClass as $class)
                     <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }} value="{{$class->id}}">{{$class->name}}</option>
                     @endforeach
                     </select>

                 </div>

                 <div class="form-group col-md-3">
                    <label for="subject_id">Môn học</label>
                    <select class="form-control getSubject" required name="subject_id">
                      <option value="">Chọn lớp học</option>
                      @if(!empty($getSubject))
                        @foreach ($getSubject as $subject)
                        <option {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }} value="{{$subject->subject_id}}">{{$subject->subject_name}}</option>
                        @endforeach
                      @endif
                      </select>
 
                  </div>


                 <div class="form-group col-md-3">
                   <button type="submit" class="btn btn-primary" style="margin-top:30px;">Tìm kiếm</button>
                   <a href="{{url("admin/student/list")}}" class="btn btn-success" style="margin-top:30px;">Làm mới</a>
                 </div>

             </div> 
             </div>
           </form>
         </div>
         @if(!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
            <div class="card">
                
                <div class="card-header"><h3>Thời khóa biểu</h3></div>
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Tuần</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Phòng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($week as $value)
                        <tr>
                        <td>{{$value['week_name']}}</td>
                        <td>
                            <input type="time" name="start_time" class="form-control" />
                        </td>
                        <td>
                            <input type="time" name="end_time" class="form-control" />
                        </td>
                        <td>
                            <input style="width: 200px;" type="text" name="room_number" class="form-control" />
                        </td>
                        </tr>
                    @endforeach
                        
                    
                    </tbody>
                </table>
                <div style="text-align: center; padding: 10px;"><button class="btn btn-primary"> Lưu </button></div>
                
                </div>
                <!-- /.card-body -->
            </div>
        @endif
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

@section('script')

<script type="text/javascript">
    $('.getClass').change(function(){
        var class_id = $(this).val();
        console.log('ntvu log', class_id);
        $.ajax({
            url: "{{ url('admin/class_timeable/get_subject') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                class_id: class_id,
            },
            dataType: "json",
            success: function(response){
                $('.getSubject').html(response.html);
            }
        })
    })
</script>

@endsection

