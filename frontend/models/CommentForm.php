<?php

namespace frontend\models;

use common\models\Comment;
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


    public function save(): bool
    {
        if ($this->validate()) {
            $comment    = new Comment();
            $comment->post_id       = $this->post_id;
            $comment->name          = $this->name;
            $comment->email         = $this->email;
            $comment->content       = $this->content;
            $comment->comment_date  = date("Y-m-d H:i:s");
            $comment->status        = Comment::STATUS_PASSIVE;

            return $comment->save();
        }

        return false;
    }
}
