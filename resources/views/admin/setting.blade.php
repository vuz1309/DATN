  @extends('layouts.app')

  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Cài đặt</h1>
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
                                          <label for="paypal_email">Paypal email</label>
                                          <input name="paypal_email" value="{{ $getRecord->paypal_email }}" type="text"
                                              required class="form-control" id="paypal_email" placeholder="">
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
