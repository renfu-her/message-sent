<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $subjectText;

    /**
     * Create a new message instance.
     *
     * @param string $messageContent
     * @param string $subjectText
     */
    public function __construct($messageContent, $subjectText)
    {
        $this->messageContent = $messageContent;
        $this->subjectText = $subjectText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectText)
            ->html($this->messageContent) // 使用 HTML 內容來渲染郵件
            ->view('emails.custom_mail') // 使用 Blade 模板來渲染郵件
            ->with([
                'messageContent' => $this->messageContent,
            ]);
    }
}
