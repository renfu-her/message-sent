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
    public $fromEmail;
    public $fromName;

    /**
     * Create a new message instance.
     *
     * @param string $messageContent
     * @param string $subjectText
     * @param string $fromEmail
     * @param string $fromName
     */
    public function __construct($messageContent, $subjectText, $fromEmail, $fromName)
    {
        $this->messageContent = $messageContent;
        $this->subjectText = $subjectText;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
            ->subject($this->subjectText)
            ->html($this->messageContent) // 使用 HTML 內容來渲染郵件
            ->view('emails.custom_mail') // 使用 Blade 模板來渲染郵件
            ->with([
                'messageContent' => $this->messageContent,
            ]);
    }
}
