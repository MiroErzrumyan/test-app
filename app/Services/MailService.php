<?php

namespace App\Services;

use App\Mail\CreateMemberEmail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendMail($email,$id)
    {
        return Mail::to($email)->send(new CreateMemberEmail($id));
    }}
