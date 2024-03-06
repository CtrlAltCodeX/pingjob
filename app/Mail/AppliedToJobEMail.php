<?php

namespace App\Mail;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppliedToJobEMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $job;
    public function __construct($request, $job)
    {
        $this->data = $request;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(get_option('email_address'), get_option('site_name'))
            ->to($this->data->email, $this->data->name)
            ->subject('Your application is received')
            ->markdown('emails.apply_to_job_email');
    }
}
