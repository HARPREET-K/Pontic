<li class="clearfix" id="message-{{$message->id}}">
    <div class="message-data align-right">
        <span class="message-data-time" >{{$message->humans_time}} ago</span> &nbsp; &nbsp;
        @if(!empty($users->profile_image_thumb))
                <img src="{{ Config('constants.s3_url') . $users->profile_image_thumb}}" />
               @else
                <div class="profileImgSec" >
                <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
               @endif
        <!--<span class="message-data-name" >{{$message->sender->name}}</span>-->
        <a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Message"><i class="fa fa-close"></i></a>
    </div>
    <div class="message other-message float-right">
        {{$message->message}}
    </div>
</li>
