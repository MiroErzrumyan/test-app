<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateMemberEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected int $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }


    /**
     * @return CreateMemberEmail
     */
    public function build(): CreateMemberEmail
    {
        return $this->from('example@example.com')
            ->markdown('emails.createMember')
            ->with([ 'url' => route('loginMember', $this->id)]);
    }
}
