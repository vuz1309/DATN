  
@extends('layouts.app')
   
@section('content')
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>Lịch thi</h1>
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
                    @foreach ($getRecord as $valueC)
                    <h2 style="font-size: 32px; margin-bottom: 16px;">Lớp: <b >{{ $valueC['class_name']}}</b></h2>
                    @foreach ($valueC['exam'] as $value )
                    <div class="card">
                        <div class="card-header">
                            <h3 class="class-title">Kì thi: {{ $value['exam_name']}}</h3>
                        </div>
                        <div style="overflow-x: auto" class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Môn học</th>
                                        <th>Ngày thi</th>
                                        <th>Bắt đầu</th>
                                        <th>Kết thúc</th>
                                        <th>Phòng</th>
                                        <th>Điểm tối đa</th>
                                        <th>Điểm đạt</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($value['subject'] as $schedule )
                                    <tr>
                                        
                                        <td>{{$schedule['subject_name']}} 
                                        </td>
                                        <td>
                                            <input readonly value="{{$schedule['exam_date']}}"   type="date" class="form-control">
                                            
                                        </td>
                                        <td>
                                            <input  readonly value="{{$schedule['start_time']}}" type="time" class="form-control">
                                        </td>
                                        <td>
                                            <input readonly  value="{{$schedule['end_time']}}"  type="time" class="form-control">
                                        </td>
                                        <td>
                                            <input readonly  value="{{$schedule['room_number']}}"  type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input  readonly value="{{$schedule['full_marks']}}"   type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input readonly value="{{ $schedule['passing_mark'] }}"  type="text" class="form-control">
                                        </td>
                                        </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                    
                    @endforeach
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


