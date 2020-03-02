<?php

namespace App\Http\Controllers;

use App\Mail\ErrorMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function error_notif_email()
    {
        Mail::to("prostiate@gmail.com")->send(new ErrorMail());

        return redirect('/dashboard');
    }
}
