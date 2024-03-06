<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    function index()
    {
        Mail::send(['text'=>'email_template'],['name'=>'Younas'],function($message)
        {
            $message->to('test@gmail.com','fiverr')->subject('Test Email');
            $message->from('shankar@pingjob.com','Shankar');
        });

    }


}
