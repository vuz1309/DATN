@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('public/plugins/select2/css/select2.min.css') }}" />
    <style>
        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 10px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 28px;
            right: 3px;
        }

        .select2-results__options {
            background-color: white
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
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
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Tiêu đề</label>
                                        <input class="form-control" required type="text" name="subject" id="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">Gửi đến (Học sinh/ Giáo viên/ Phụ huynh)</label>
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
                                        <label for="">Tin nhắn</label>
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
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            // $('#selectUser').select2({
            //     placeholder: 'Chọn hoặc tìm kiếm...',
            //     ajax: {
            //         url: "{{ url('admin/communicate/search_user') }}",
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

            $('#compose-textarea').summernote({
                height: 200
            })
        })
    </script>
@endsection
