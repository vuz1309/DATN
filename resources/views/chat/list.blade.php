@extends('layouts.app')
@section('style')
    <style>
        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
            height: calc(100vh - 160px);
            overflow-y: auto;
        }

        .content-wrapper {
            overflow-x: hidden;
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s;
            height: calc(100vh - 160px);
            overflow-y: auto;
            border-right: 1px solid #ccc;
        }



        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff;
            height: calc(100vh - 322px);
            overflow-y: auto
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .my-message {
            background: #efefef
        }

        .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #efefef;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .other-message {
            background: #e8f1f3;
            text-align: right
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #e8f1f3;
            left: 67%
        }

        .chat .chat-message {
            padding: 20px
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow: auto
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app" style="position: relative">
                    @include('_loading')
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input id="getSearch" type="text" class="form-control" placeholder="Tìm kiếm...">
                            <input id="getReceiverIDDynamic" type="hidden" class="form-control"
                                value="{{ $receiver_id }}">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0" id="getSearchUserDynamic">
                            @include('chat._user')
                        </ul>
                    </div>
                    <div class="chat" id="getChatMessageAll" style="position: relative">
                        @include('chat._message')

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var isLoading = false;

        // function genLoadingChat(data) {
        //     const html = `
    //                             <li class="clearfix">
    //     <div class="message-data text-right">
    //         <span class="message-data-time"><div class="spinner-border" role="status">

    //                                 </div></span>
    //         <img src="${data.sender_avatar}" alt="avatar">
    //     </div>
    //     <div class="message other-message float-right"> ${data.message || ''} 
    //         ${data.file_path ? `<div><a href="${data.file_path}" download="" target="_blank">Tải xuống</a></div>` : ''}

    //     </div>

    // </li>

    //                             `;
        //     $('#AppendMessage').append(html);
        //     setTimeout(() => {
        //         scrolldown();
        //     }, 1);

        // }
        $('body').delegate('.getChatWindows', 'click', function(e) {
            e.preventDefault();
            const receiver_id = $(this).attr('id');
            console.log('getChatwindow');
            $('.getChatWindows').removeClass('active');
            $(this).addClass('active');
            if (!isLoading && receiver_id != $('#getReceiverIDDynamic').val()) {
                isLoading = true;
                console.log('getChatwindow_callAPI');

                $('#getReceiverIDDynamic').val(receiver_id);
                showLoading(true);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('get_chat_windows') }}",
                    data: {
                        receiver_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        isLoading = false;
                        showLoading(false);

                        $(`#ClearMessage${receiver_id}`).hide();
                        $('#message_text').val('');
                        $('#getChatMessageAll').html(data.success);
                        window.history.pushState('', '',
                            "{{ url('chat?receiver_id=') }}" + receiver_id)
                        scrolldown();
                    },
                    error: function(data) {
                        isLoading = false;
                        showLoading(false);

                    },
                });
            }

        });
        $('body').delegate('#submit_message', 'submit', function(e) {
            e.preventDefault();
            console.log('ntvu', $('#message_text').val());
            if (!isLoading && ($('#message_text').val() && $('#message_text').val().length || $('#file_name')
                    .val())) {
                isLoading = true;
                showLoading(true);
                // genLoadingChat({
                //     message: $('#message_text').val(),
                //     file_path: null,
                //     sender_avatar: "{{ Auth::user()->getProfile() }}"
                // });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('submit_message') }}",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        isLoading = false;
                        $('#AppendMessage').append(data.success);
                        $('#message_text').val('');
                        $('#file_name').val('');
                        $('#FileDisplay').html('');
                        $('#FileDisplay').hide();
                        scrolldown();
                        showLoading(false);

                    },
                    error: function(data) {
                        showLoading(false);
                        isLoading = false;
                    },
                });
            }


        });
        $("#message_text").keydown(function(event) {

            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                $('#submit_message').trigger('submit');
            }
        });
        $('#getSearch').change(function(e) {
            const search = $(this).val();
            const receiver_id = $('#getReceiverIDDynamic').val();
            console.log('search');
            if (!isLoading) {
                isLoading = true;
                showLoading(true);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('get_chat_search_user') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search,
                        receiver_id,
                        page: 1
                    },
                    dataType: 'json',
                    success: function(data) {
                        isLoading = false;
                        $('#getSearchUserDynamic').html(data.success);
                        showLoading(false);

                    },
                    error: function(data) {
                        showLoading(false);
                        isLoading = false;
                    },
                });
            }

        });

        function scrolldown() {
            $('.chat-history').animate({
                scrollTop: $('.chat-history').prop('scrollHeight') + 30000
            }, 1000);
        }
        scrolldown();
        $('body').delegate('#OpenFile', 'click', function(e) {
            $('#file_name').trigger('click');
        });
        $('body').delegate('#file_name', 'change', function(e) {
            const filename = this.files[0].name;
            console.log('file:', filename);
            $('#FileDisplay').html(filename);
            $('#FileDisplay').show();
        });
    </script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6ca4e425389bb6f26105', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('message');
        channel.bind('chat', function(data) {
            if ($('#AppendMessage') && data.receiver_id === "{{ Auth::user()->id }}") {
                const receiverId = "{{ Auth::user()->id }}";

                console.log('getted', data);
                const newMessageHtml = `<li class="clearfix">
                                        <div class="message-data"><img src="${data.sender_avatar}" alt="avatar">
                                            <span class="message-data-time"> ${data.diffForHumans}</span>

                                        </div>
                                        <div class="message my-message ">  ${data.message || ''} 
                                           
                                                ${data.file_path ? `<div>
                                                                                                                                                                                                                                <a href="${data.file_path}" download="" target="_blank">Tải xuống</a>
                                                                                                                                                                                                                            </div>` : ''}
                                          

                                        </div>
                                    </li>`;
                $('#AppendMessage').append(newMessageHtml);
                setTimeout(() => {
                    scrolldown();
                }, 1);

            }
        });
    </script>
@endsection
