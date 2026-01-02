<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва мітки',
            'slug' => 'URL',
            'created_at' => 'Дата створення',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (empty($this->slug)) {
            $this->slug = $this->generateSlug($this->name);
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

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])
            ->viaTable('{{%post_tag}}', ['tag_id' => 'id']);
    }
}
