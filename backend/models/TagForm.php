<?php
namespace backend\models;

use common\models\Category;
use common\models\Tag;
use common\my\Helper;
use Yii;
use yii\base\Model;
use common\models\Post;
use yii\web\NotFoundHttpException;


/**
 * Class TagForm
 *
 * @package backend\models
 *
 * @property Tag $_item
 */
class TagForm extends Model
{
    public $_item;

    public $slug;
    public $name;
    public $description;
    public $status;

    public function __construct($config = [])
    {
        $this->_item   = new Tag();

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
                [['slug', 'name', 'description'], 'string'],
                [['status'], 'integer'],
                [['name'], 'required'],
                ['status', 'in', 'range' => array_keys(Tag::$statuses)],
            ]
        );
    }


    public function attributeLabels(): array
    {
        return Tag::$labels;
    }

    /**
     * Varolan bir kayıt değiştirilmek isteniyorsa bunu çalıştırmak lazım.
     *
     * @param $id
     * @throws NotFoundHttpException
     */
    public function findItem($id)
    {
        $this->_item    = Tag::findOne($id);

        if (!$this->_item) {
            throw new NotFoundHttpException('Etiket Bulunamadı.');
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
            $this->_item->slug          = empty($this->slug) ? Helper::slugify($this->name) : Helper::slugify($this->slug);
            $this->_item->name          = $this->name;
            $this->_item->description   = $this->description;
            $this->_item->status        = $this->status;

            if ($this->_item->save($runValidation, $attributeNames)) {
                return true;
            }
        }

        return false;
    }
}