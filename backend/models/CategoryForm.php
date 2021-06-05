<?php
namespace backend\models;

use common\models\Category;
use common\my\Helper;
use Yii;
use yii\base\Model;
use common\models\Post;
use yii\web\NotFoundHttpException;


/**
 * Class CategoryForm
 *
 * @package backend\models
 *
 * @property Category $_item
 */
class CategoryForm extends Model
{
    public $_item;

    public $parent_id;
    public $slug;
    public $name;
    public $description;
    public $status;

    public function __construct($config = [])
    {
        $this->_item   = new Category();

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
                [['parent_id', 'status'], 'integer'],
                [['name'], 'required'],
                [['parent_id'], 'default', 'value' => 0],
                ['status', 'in', 'range' => array_keys(Category::$statuses)],
            ]
        );
    }


    public function attributeLabels(): array
    {
        return Category::$labels;
    }

    /**
     * Varolan bir kayıt değiştirilmek isteniyorsa bunu çalıştırmak lazım.
     *
     * @param $id
     * @throws NotFoundHttpException
     */
    public function findItem($id)
    {
        $this->_item    = Category::findOne($id);

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
            $this->_item->parent_id     = $this->parent_id;
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