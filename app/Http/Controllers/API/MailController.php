<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * 发送邮件的 API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMail(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'emails' => 'required|array', // 接受多个 email
            'emails.*' => 'required|email', // 每个 email 必须是有效的
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $emails = $request->input('emails');
        $subject = $request->input('subject');
        $messageContent = $request->input('message');

        dd($emails, $subject, $messageContent);

        // 遍历所有收件人并发送邮件
        foreach ($emails as $email) {
            Mail::to($email)->send(new CustomMail($messageContent, $subject));
        }

        // 返回成功响应
        return response()->json(['message' => 'Emails sent successfully'], 200);
    }
}
