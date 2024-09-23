<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

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
            'mail_username' => 'required|string', // 邮件用户名
            'mail_password' => 'required|string', // 邮件密码
        ]);

        // 动态设置邮件用户名和密码
        Config::set('mail.username', $request->input('mail_username'));
        Config::set('mail.password', $request->input('mail_password'));

        $emails = $request->input('emails');
        $subject = $request->input('subject');
        $messageContent = $request->input('message');

        // 遍历所有收件人并发送邮件
        foreach ($emails as $email) {
            Mail::to($email)->send(new CustomMail($messageContent, $subject, 'text/html'));
        }

        // 返回成功响应
        return response()->json(['message' => 'Emails sent successfully'], 200);
    }
}
