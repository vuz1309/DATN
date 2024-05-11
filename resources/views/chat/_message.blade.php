@if (!empty($getReceiver))
    @include('chat._header')
    <div class="chat-history">
        @include('chat._chat')
    </div>
    <div style="position: relative" class="chat-message clearfix">

        <form enctype="multipart/form-data" action="" id="submit_message" method="post" class="input-group mb-0">
            {{ csrf_field() }}
            <div id="FileDisplay"
                style="position: absolute; top: -34px; left: 0; z-index: 999; display: none; text-align: right; width: 100%">

            </div>
            <input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}" />
            <div id="send_message_btn" class="input-group-prepend">
                <button class="input-group-text btn"><i class="fa fa-send"></i></button>
            </div>
            <textarea name="message" id="message_text" rows="1" type="text" class="form-control"
                placeholder="Nhập tin nhắn..."> </textarea>

            <div class="input-group-after">
                <input type="file" name="file_name" id="file_name" hidden>
                <a id="OpenFile" href="javascript:void(0);" class="btn btn-info"><i class="fa fa-image"></i></a>
            </div>
        </form>

    </div>
@else
@endif
