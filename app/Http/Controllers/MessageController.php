<?php

namespace App\Http\Controllers;

use App\Artwork;
use App\Http\Requests\AddMessageRequest;
use App\Http\Requests\UpBalanceRequest;
use App\Image;
use App\Message;
use App\MessageType;
use App\MessageUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function indexShow($user_id, $type_id = null) {


        $user=User::find($user_id);
        if($user_id == Auth::id()) {
            $messages = $user->incoming_messages->where('type_id', $type_id);
            $n = 0;
            if ($type_id == 1) {
                $headline = 'Уведомления';
            } elseif ($type_id == 2) {
                $headline = 'Жалобы';
            } elseif ($type_id == 3) {
                $headline = 'Предложения';
            } elseif ($type_id == 4) {
                $headline = 'Пополнение баланса';
            } elseif ($type_id == null) {
                $messages = $user->outgoing_messages;
                $headline = 'Исходящие сообщения';
            }

            if ($type_id != 1 && $user->role_id != 1) {
                return redirect()->back();
            } else {

                return view('message.messagesIndex')
                    ->with([
                        'messages' => $messages,
                        'user' => $user,
                        'headline' => $headline,
                        'type_id' => $type_id,
                        'n' => $n,
                    ]);
            }
        }
        else {
            return redirect()->back();
        }

    }

    public function show($id) {


        $message = Message::find($id);
        if($message->seen == false) {
            $message->update([
                'seen' => true
            ]);
        }
        return view('message.showMessage')
            ->with([
                'message' => $message,
            ]);
    }

    public function add($user_id) {

        $user = User::find($user_id);
        $types = MessageType::all();

        return view('message.addMessage')
            ->with([
                'user' => $user,
                'types' => $types,
            ]);
    }

    public function store(AddMessageRequest $request) {

        $success='Сообщение успешно отправлено';


        if($request->uve == 'adm') {

            $message = Message::create([
                'theme' => $request->theme,
                'type_id' => $request->type,
                'text' => $request->text,
                'user_id' => $request->user_id,
                'artwork_id' => $request->artwork_id,
            ]);

            foreach (User::where('role_id', 1)->get() as $recipient) {
                MessageUser::create([
                    'message_id' => $message->id,
                    'user_id' => $recipient->id,
                ]);
            }

            return redirect()->back()->with('success', $success);
        }

        elseif ($request->uve == 'uve') {

            $message = Message::find($request->message_id);

            $re_message = Message::create([
                'theme' => 'На вашу книгу поступила жалоба',
                'type_id' => 1,
                'text' => $message->text,
                'user_id' => $request->user_id,
                'artwork_id' => $request->artwork_id,
            ]);

            MessageUser::creare([
                'message_id' => $re_message->id,
                'user_id' => $request->recipient,
            ]);
            return redirect()->back()->with('success', $success);
        }

        elseif ($request->uve == 'msg') {

            $message = Message::create([
                'theme' => $request->theme,
                'type_id' => 1,
                'text' => $request->text,
                'user_id' => $request->user_id,
            ]);

            MessageUser::creare([
                'message_id' => $message->id,
                'user_id' => $request->recipient,
            ]);

            return redirect()->back()->with('success', $success);
        }

    }

    public function upBalance () {

        return view('message.upBalance');


    }

    public function upBalanceStore (UpBalanceRequest $request) {

        $image_path=$request->file('check')->storePublicly('public/checks_img');
        $image_path=preg_replace( "#public/#", "", $image_path );

        $image = Image::create([
            'image_path' => $image_path,
        ]);

        $message=Message::create([
            'type_id' => $request->type,
            'text' => $request->sum,
            'user_id' => $request->user_id,
            'theme' => 'Пополнение баланса',
            'image_id' => $image->id,
        ]);

        foreach (User::where('role_id', 1)->get() as $recipient) {
            MessageUser::create([
                'message_id' => $message->id,
                'user_id' => $recipient->id,
            ]);
        }

        return redirect()->back()->with('success', 'Сообщение отправлено');



    }

}
