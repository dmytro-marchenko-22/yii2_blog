<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use app\models\Category;
use app\models\Tag;
use app\models\Post;

class InitController extends Controller
{
    public $defaultAction = 'db';

    /**
     * Initialize database with sample data
     */
    public function actionDb()
    {
        $this->stdout("Инициализация базы данных...\n");

        // Create admin user
        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'admin@example.com';
        $admin->setPassword('admin123');
        $admin->generateAuthKey();
        $admin->generateAccessToken();
        $admin->status = User::STATUS_ACTIVE;
        
        if ($admin->save()) {
            $this->stdout("✓ Администратор создан (admin/admin123)\n", yii\helpers\Console::FG_GREEN);
        } else {
            $this->stdout("✗ Ошибка при создании администратора\n", yii\helpers\Console::FG_RED);
            return ExitCode::DATAERR;
        }

        // Create categories
        $categories = [
            ['name' => 'Смартфоны', 'description' => 'Обзоры и новости о смартфонах'],
            ['name' => 'Планшеты', 'description' => 'Информация о планшетных компьютерах'],
            ['name' => 'Аксессуары', 'description' => 'Аксессуары и зарядные устройства'],
            ['name' => 'Технологии', 'description' => 'Новые технологии в мобильной индустрии'],
        ];

        foreach ($categories as $data) {
            $category = new Category();
            $category->name = $data['name'];
            $category->description = $data['description'];
            if ($category->save()) {
                $this->stdout("✓ Категория '{$data['name']}' создана\n", yii\helpers\Console::FG_GREEN);
            }
        }

        // Create tags
        $tags = [
            'iPhone', 'Samsung', 'Android', 'iOS', 'Обзор', 
            '5G', 'Камера', 'Батарея', 'Дизайн', 'Производительность'
        ];

        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->name = $tagName;
            if ($tag->save()) {
                $this->stdout("✓ Метка '{$tagName}' создана\n", yii\helpers\Console::FG_GREEN);
            }
        }

        $this->stdout("\nБаза данных инициализирована!\n", yii\helpers\Console::FG_GREEN);
        return ExitCode::OK;
    }
}
