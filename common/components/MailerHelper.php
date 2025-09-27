<?php

namespace common\components;

use Yii;

class MailerHelper
{
    /**
     * Gửi email đơn giản
     *
     * @param string|array $to    Email người nhận (chuỗi hoặc mảng)
     * @param string       $subject Tiêu đề mail
     * @param string       $body   Nội dung HTML
     * @param string|array $from   Email người gửi (nếu null lấy default)
     * @return bool
     */
    public static function send($to, $subject, $body, $from = null)
    {
        try {
            $mailer = Yii::$app->mailer->compose()
                ->setTo($to)
                ->setSubject($subject)
                ->setHtmlBody($body);

            if ($from !== null) {
                $mailer->setFrom($from);
            } else {
                $mailer->setFrom([Yii::$app->params['adminEmail'] => 'System']);
            }

            return $mailer->send();
        } catch (\Exception $e) {
            $error = $e->getMessage(); // ✅ Ghi lỗi vào biến tham chiếu

            Yii::$app->session->setFlash('error', 'Mailer error: ' . $e->getMessage());
            return false;
        }
    }
}
