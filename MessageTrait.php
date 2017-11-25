<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\message;

use Yii;

/**
 * Trait Message
 * @package yuncms\message
 */
trait Message
{
    /**
     * 获取模块配置
     * @param string $key
     * @param null $default
     * @return bool|mixed|string
     */
    public function getSetting($key, $default = null)
    {
        $value = Yii::$app->settings->get($key, 'user', $default);
        if ($key == 'avatarUrl' || $key == 'avatarPath') {
            return Yii::getAlias($value);
        }
        return $value;
    }

    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('user');
    }

    /**
     * 给用户发送邮件
     * @param string $to 收件箱
     * @param string $subject 标题
     * @param string $view 视图
     * @param array $params 参数
     * @return boolean
     */
    public function sendMessage($to, $subject, $view, $params = [])
    {
        if (empty($to)) {
            return false;
        }
        $message = Yii::$app->mailer->compose([
            'html' => '@yuncms/message/mail/' . $view,
            'text' => '@yuncms/message/mail/text/' . $view
        ], $params)->setTo($to)->setSubject($subject);
        return $message->send();
    }
}