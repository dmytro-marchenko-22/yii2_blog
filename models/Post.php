<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Post extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'content'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['category_id', 'author_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва статті',
            'category_id' => 'Категорія',
            'content' => 'Вміст',
            'image' => 'Зображення',
            'status' => 'Статус',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата оновлення',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (empty($this->slug)) {
            $this->slug = $this->generateSlug($this->title);
        }

        return true;
    }

    public function generateSlug($string)
    {
        $transliteration = [
            'а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'h',  'ґ' => 'g',
            'д' => 'd',  'е' => 'e',  'є' => 'ie', 'ж' => 'zh', 'з' => 'z',
            'и' => 'y',  'і' => 'i',  'ї' => 'i',  'й' => 'i',
            'к' => 'k',  'л' => 'l',  'м' => 'm',  'н' => 'n',
            'о' => 'o',  'п' => 'p',  'р' => 'r',  'с' => 's',
            'т' => 't',  'у' => 'u',  'ф' => 'f',  'х' => 'kh',
            'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
            'ь' => '',   'ю' => 'iu', 'я' => 'ia',
            
            'А' => 'A',  'Б' => 'B',  'В' => 'V',  'Г' => 'H',  'ґ' => 'G',
            'Д' => 'D',  'Е' => 'E',  'Є' => 'Ie', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'Y',  'І' => 'I',  'Ї' => 'I',  'Й' => 'I',
            'К' => 'K',  'Л' => 'L',  'М' => 'M',  'Н' => 'N',
            'О' => 'O',  'П' => 'P',  'Р' => 'R',  'С' => 'S',
            'Т' => 'T',  'У' => 'U',  'Ф' => 'F',  'Х' => 'Kh',
            'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
            'Ь' => '',   'Ю' => 'Iu', 'Я' => 'Ia',
        ];
        
        $slug = strtr($string, $transliteration);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%post_tag}}', ['post_id' => 'id']);
    }

    public function uploadImage()
    {
        if (!$this->imageFile) {
            return true; 
        }

        if ($this->imageFile->error !== UPLOAD_ERR_OK) {
            \Yii::error('File upload error: ' . $this->imageFile->error);
            return false; 
        }

        $ext = strtolower($this->imageFile->extension);
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $this->addError('imageFile', 'Недозволений формат файлу.');
            return false;
        }

        if ($this->imageFile->size > 5242880) {
            $this->addError('imageFile', 'Файл занадто великий.');
            return false;
        }

        $filename = $this->imageFile->baseName . '.' . $ext;
        $path = \Yii::getAlias('@webroot/uploads/') . $filename;
        
        if ($this->imageFile->saveAs($path)) {
            $this->image = \Yii::$app->request->baseUrl . '/uploads/' . $filename;
            return true;
        }
        
        $this->addError('imageFile', 'Помилка при завантаженні файлу.');
        return false;
    }
}