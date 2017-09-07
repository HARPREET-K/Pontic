<div class="people-list" id="people-list">
    <div class="search" style="text-align: center">
        <div class="inbox"><i class="fa fa-envelope"></i> Inbox </div>
    </div>
    <ul class="list">
        @foreach($threads as $inbox)
        @if(!is_null($inbox->thread))
        <li class="clearfix <?php
        $str = $_SERVER["REQUEST_URI"];
        preg_match_all('/[0-9]+/', $str, $matches);
        $checkForActive = $matches[0][1];
        if ($checkForActive == $inbox->withUser->id) {
            echo 'active';
        } else {
            
        }
        ?> " >

            <a href="{{route('message.read', ['id'=>$inbox->withUser->id])}}<?php //echo $inbox->thread->reciever_id;   ?>">
                @if(!empty($inbox->withUser->profile_image_thumb))
                <img src="{{ Config('constants.s3_url') . $inbox->withUser->profile_image_thumb}}" />
                @else
                <div class="profileImgSec" >
                    <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                <div class="about">
                    <div class="name">{{$inbox->withUser->name}}</div>
                    <div class="status">
                        @if(auth()->user()->id == $inbox->thread->sender->id)
                        <span class="fa fa-reply"></span>
                        @endif
                        <span>{{substr($inbox->thread->message, 0, 15)}}  <?php
        //if($inbox->thread->is_seen == '0'){
        // echo '<div style="color:red">New Message</div>';
        //}
        // else { 
        /// }
        ?></span>
                    </div>
                </div>
            </a>
        </li>
        @endif
        @endforeach

    </ul>
</div>

