<?php

namespace App\Http\Controllers;

use App\User;
use App\OfficeInformation;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use Auth;
use View;
use DB;

class MessageController extends Controller
{
    protected $authUser;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('talk');
        if(!Auth::guest()) {
        Talk::setAuthUserId(Auth::user()->id);
        }

        View::composer('partials.peoplelist', function($view) {
            $threads = Talk::threads();
            //$reciever_id = $_GET['u'];
            $user = Auth::user();
             $messageCounters = DB::select('select * from messages where is_seen = ? AND reciever_id = ?',[0,$user->id]);
            $view->with(compact('threads','messageCounters'));
        });
    }

    public function chatHistory($id)
    {
         
        $user = Auth::user();
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        //$reciever_id = $_GET['u'];
       //DB::update('update messages set is_seen = ? where reciever_id = ?',[1,$reciever_id]);
       $messageCounter = DB::select('select * from messages where is_seen = ? AND reciever_id = ?',[0,$user->id]);
       $conversations = Talk::getMessagesByUserId($id);
        $users = '';
        $messages = [];
        if(!$conversations) {
            $users = User::find($id);
        } else {
            $users = $conversations->withUser;
            $messages = $conversations->messages;
        }

        return view('messages.conversations', compact('messages','officeInformation','messageCounter', 'users','user'));
    }

    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];

            $this->validate($request, $rules);

            $body = $request->input('message-data');
            $userId = $request->input('_id');

            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $users = Auth::user();
                $html = view('ajax.newMessageHtml', compact('message','users'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }

    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }

            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }

    public function tests()
    {
        dd(Talk::channel());
    }
    public function makeSeen($id){
        
        Talk::makeSeen($messageId);
    }
}
