@extends('layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Nộp bài tập (Học sinh: {{ $getRecord->getStudent->name }}
                            {{ $getRecord->getStudent->last_name }})</h1>
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
                                        @if (!empty($getRecord->getDocument()))
                                            <a download="" href="{{ $getRecord->getDocument() }}"
                                                class="btn btn-primary">Tải
                                                xuống</a>
                                        @else
                                            <div>--Không có tệp tài liệu--</div>
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="">Mô tả</label>
                                        <textarea readonly id="compose-textarea" name="description" class="form-control" style="height: 300px">{{ $getRecord->description }}</textarea>
                                    </div>
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
