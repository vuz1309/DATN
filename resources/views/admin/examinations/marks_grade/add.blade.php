  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Thêm mới thang điểm</h1>
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
                              <form method="post" action="">
                                  {{ csrf_field() }}
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label for="name">Tên<span style="color: red;">*</span></label>
                                          <input name="name" type="text" required class="form-control" id="name"
                                              placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label for="percent_from">Điểm từ<span style="color: red;">*</span></label>
                                          <input step="0.01" name="percent_from" type="number" required
                                              class="form-control" id="percent_from" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label for="percent_to">Điểm đến<span style="color: red;">*</span></label>
                                          <input step="0.01" name="percent_to" type="number" required
                                              class="form-control" id="percent_to" placeholder="">
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
