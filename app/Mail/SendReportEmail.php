<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReportEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $content;
    /**
     * Create a new message instance.
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subject) 
            ->view('Pages.Email.report')   
            ->with([                         
                'content' => $this->content,
            ])
            ->attach(public_path('/files/report.pdf'), [ 
                'as' => 'report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
