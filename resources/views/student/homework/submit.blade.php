@extends('layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Nộp bài tập</h1>
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
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="card-body" style="overflow: auto;">

                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="">Tài liệu</label>
                                        <input class="form-control" type="file" name="document_file" id="document_file">

                                    </div>

                                    <div class="form-group">
                                        <label for="">Mô tả</label>
                                        <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px"></textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Nộp bài</button>
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
    {{-- <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script> --}}
    <script type="text/javascript">
        $(function() {
            $('#compose-textarea').summernote({
                height: 200
            })
        })
    </script>
@endsection
