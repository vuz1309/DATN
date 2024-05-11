<div class="chat-header clearfix">
    <div class="row">
        <div class="col-lg-6">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                <img src="{{ $getReceiver->getProfile() }}" alt="avatar">
            </a>
            <div class="chat-about">
                <h6 class="m-b-0">{{ $getReceiver->name }} {{ $getReceiver->last_name }}</h6>
                <small>
                    @if (!empty($getReceiver->OnlineUser()))
                        <div class="status"> <i class="fa fa-circle online"></i> <span>Đang hoạt động</span> </div>
                    @else
                        <i class="fa fa-circle offline"></i>
                        {{ Carbon\Carbon::parse($getReceiver->updated_at)->diffForHumans() }}
                    @endif

                </small>
            </div>
        </div>
        {{-- <div class="col-md-6 hidden-sm text-right">
            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
        </div> --}}
    </div>
</div>
