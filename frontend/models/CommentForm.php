<?php

namespace frontend\models;

use common\models\Post;
use Yii;
use yii\base\Model;

/**
 * CommentForm is the model behind the contact form.
 */
class CommentForm extends Model
{
    public $post_id;
    public $name;
    public $email;
    public $content;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'content'], 'required'],
            ['post_id', 'exist', 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name'          => 'Ad Soyad',
            'email'         => 'Mail Adresi',
            'content'       => 'Mesaj',
            'verifyCode'    => 'Resimde Gördüğünüzü Kutucuğa Giriniz',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail(string $email): bool
    {
        return '';
    }
}
