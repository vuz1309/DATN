  
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

         <div class="card">
                
                <div class="card-header"><h3>Lớp: <span style="font-weight: bold">{{$getClass->name}}</span> - Môn:   <span style="font-weight: bold">{{$getSubject->name}}</span></h3></div>
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

                      @php
                        $i = 1;
                      @endphp

                    @foreach ($week as $value)
                      <tr>
                        <td> 
                          <span style="font-weight: bold;">{{$value['week_name']}}</span> 
                        </td>
                        <td>
                            <input style="max-width: 200px" disabled type="time" value="{{$value['start_time']}}" name="timeable[{{$i}}][start_time]" class="form-control" />
                        </td>
                        <td>
                            <input style="max-width: 200px" disabled type="time" value="{{$value['end_time']}}"  name="timeable[{{$i}}][end_time]" class="form-control" />
                        </td>
                        <td>
                            <input style="max-width: 200px" disabled  value="{{$value['room_number']}}"   type="text" name="timeable[{{$i}}][room_number]" class="form-control" />
                        </td>
                        </tr>
                        @php
                        $i++;
                      @endphp

                    @endforeach
                    </tbody>
                </table>                
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

@section('script')

<script type="text/javascript">
    $('.getClass').change(function(){
        var class_id = $(this).val();
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

