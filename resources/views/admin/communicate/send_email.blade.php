@extends('layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        {{-- @include('_alert_dialog') --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gửi thông báo qua email</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('_message')
                        <div class="card card-primary">
                            <form id="form" action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Tiêu đề <span style="color: red">*</span></label>
                                        <input class="form-control" required type="text" name="subject" id="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">Gửi đến (Học sinh/ Giáo viên/ Phụ huynh) <span
                                                style="color: red">*</span></label>
                                        <select style="width: 100%;" name="user_id[]" class="form-control"
                                            multiple="multiple" id="selectUser">
                                            @foreach ($getUser as $user)
                                                <option value="{{ $user['id'] }}"> {{ $user['text'] }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label style="display: block">Gửi đến toàn bộ:</label>
                                        <label style="margin-right: 50px">
                                            <input type="checkbox" name="message_to[]" value="3"> Học
                                            sinh</label>
                                        <label style="margin-right: 50px">
                                            <input type="checkbox" name="message_to[]" value="2"> Giáo
                                            viên</label>
                                        <label style="margin-right: 50px">
                                            <input type="checkbox" name="message_to[]" value="4"> Phụ
                                            huynh</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tin nhắn <span style="color: red">*</span></label>
                                        <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('.select2').select2()
            // $('#selectUser').select2({
            //     placeholder: 'Chọn hoặc tìm kiếm...',
            //     ajax: {
            //         url: "{{ url('vAdmin/communicate/search_user') }}",
            //         dataType: 'json',
            //         delay: 250,
            //         data: function(data) {
            //             return {
            //                 search: data.term
            //             };
            //         },
            //         processResults: function(response) {
            //             return {
            //                 results: response
            //             }
            //         },
            //         cache: true
            //     }
            // });
            // $('#selectUser').select2();

            $('#form').validate({
                rules: {
                    subject: {
                        required: true,

                    },
                    message: {
                        required: true,

                    },
                },
                messages: {
                    subject: {
                        required: 'Không được để trống',


                    },
                    message: {
                        required: 'Không được để trống',


                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#form').submit(function(event) {
                // Kiểm tra nếu user_id[] trống và message_to[] cũng trống
                if ($('[name="user_id[]"]').val().length === 0 && $('[name="message_to[]"]:checked')
                    .length === 0) {
                    // Hiển thị thông báo lỗi và ngăn chặn việc submit form
                    showAlert('Lỗi', 'Bạn phải chọn ít nhất một người nhận hoặc chọn "Gửi đến toàn bộ"');
                    event.preventDefault();
                    return;
                }
                if ($('[name="user_id[]"]').val().length === 0) {
                    showAlert('Lỗi', 'Tin nhắn không được để trống');
                    event.preventDefault();
                    return;
                }
            });
            $('#compose-textarea').summernote({
                height: 200
            })
        })
    </script>
@endsection
