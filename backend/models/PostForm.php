<?php
namespace backend\models;

use common\my\Helper;
use Yii;
use yii\base\Model;
use common\models\Post;
use yii\web\NotFoundHttpException;


/**
 * Class PostForm
 *
 * @package backend\models
 *
 * @property Post $_item
 */
class PostForm extends Model
{
    public $_item;

    public $type;
    public $slug;
    public $title;
    public $content;
    public $comment_status;
    public $post_date;
    public $post_status;

    public function __construct($config = [])
    {
        $this->_item   = new Post();

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return  array_merge(
            $this->_item->rules(),
            [
                [['slug', 'title', 'content'], 'string'],
                [['type', 'comment_status', 'post_status'], 'integer'],
                [['title'], 'required'],

                ['type', 'in', 'range' => [Post::POST_TYPE_PAGE, Post::POST_TYPE_POST]],
                ['comment_status', 'in', 'range' => array_keys(Post::$comment_statuses)],
                ['post_status', 'in', 'range' => array_keys(Post::$post_statuses)],
            ]
        );
    }


    public function attributeLabels(): array
    {
        return Post::$labels;
    }

    /**
     * Varolan bir kayıt değiştirilmek isteniyorsa bunu çalıştırmak lazım.
     *
     * @param $id
     * @throws NotFoundHttpException
     */
    public function findItem($id)
    {
        $this->_item    = Post::findOne($id);

        if (!$this->_item) {
            throw new NotFoundHttpException('İçerik Bulunamadı.');
        }

        $this->setAttributes($this->_item->getAttributes());
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save(bool $runValidation = true, $attributeNames = null): bool
    {
        if ($this->validate())
        {
            $this->_item->type              = $this->type;
            $this->_item->slug              = empty($this->slug) ? Helper::slugify($this->title) : Helper::slugify($this->slug);
            $this->_item->title             = $this->title;
            $this->_item->content           = $this->content;
            $this->_item->comment_status    = $this->comment_status;
            $this->_item->post_date         = $this->post_date;
            $this->_item->post_status       = $this->post_status;

            if ($this->_item->save($runValidation, $attributeNames)) {
                return true;
            }
        }

        return false;
    }


}