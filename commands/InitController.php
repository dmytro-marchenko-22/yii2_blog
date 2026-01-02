<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use app\models\Category;
use app\models\Tag;
use app\models\Post;
use yii\helpers\Console; 

class InitController extends Controller
{
    public $defaultAction = 'db';

    /**
     * Ініціалізація бази даних з початковими даними
     */
    public function actionDb()
    {
        $this->stdout("Ініціалізація бази даних...\n");

        // Створення адміністратора
        $existingAdmin = User::findOne(['username' => 'admin']);
        if ($existingAdmin) {
            $this->stdout("Адміністратор уже існує (admin/admin123)\n", Console::FG_GREEN);
        } else {
            $admin = new User();
            $admin->username = 'admin';
            $admin->email = 'admin@example.com';
            $admin->setPassword('admin123');
            $admin->generateAuthKey();
            $admin->generateAccessToken();
            $admin->status = User::STATUS_ACTIVE;
            
            if ($admin->save()) {
                $this->stdout("Адміністратор створений (admin/admin123)\n", Console::FG_GREEN);
            } else {
                $this->stdout("Помилка при створенні адміністратора: " . implode(', ', array_map(function($e) { return implode(', ', $e); }, $admin->getErrors())) . "\n", Console::FG_RED);
            }
        }

        // Створення категорій
        $categories = [
            ['name' => 'Смартфони', 'description' => 'Огляди та новини про смартфони'],
            ['name' => 'Планшети', 'description' => 'Інформація про планшетні комп\'ютери'],
            ['name' => 'Аксесуари', 'description' => 'Аксесуари та зарядні пристрої'],
            ['name' => 'Технології', 'description' => 'Нові технології в мобільній індустрії'],
        ];

        foreach ($categories as $data) {
            $category = new Category();
            $category->name = $data['name'];
            $category->description = $data['description'];
            if ($category->save()) {
                $this->stdout("Категорія '{$data['name']}' створена\n", Console::FG_GREEN);
            }
        }

        // Створення міток
        $tags = [
            'iPhone', 'Samsung', 'Android', 'iOS', 'Огляд', 
            '5G', 'Камера', 'Батарея', 'Дизайн', 'Продуктивність'
        ];

        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->name = $tagName;
            if ($tag->save()) {
                $this->stdout("Мітка '{$tagName}' створена\n", Console::FG_GREEN);
            }
        }

        // Створення зразків публікацій
        $admin = User::findOne(['username' => 'admin']);
        $categories = Category::find()->all();
        $allTags = Tag::find()->all();
        
        if ($admin && !empty($categories) && !empty($allTags)) {
            $posts = [
                [
                    'title' => 'iPhone 15 Pro - найновіший флагман Apple',
                    'content' => 'Новий iPhone 15 Pro представляє революційні можливості з потужним чипом A17 Pro та покращеною камерою. Дізнайтеся про найважливіші функції та оновлення.',
                    'category_id' => $categories[0]->id,
                    'status' => 1,
                ],
                [
                    'title' => 'Samsung Galaxy S24 - топ Android смартфон',
                    'content' => 'Samsung Galaxy S24 пропонує безпрецедентні можливості обробки штучного інтелекту та фотографування на мобільному пристрої.',
                    'category_id' => $categories[0]->id,
                    'status' => 1,
                ],
                [
                    'title' => 'iPad Pro 2024 - найпотужніший планшет',
                    'content' => 'Новий iPad Pro з процесором M4 та OLED дисплеєм готує революцію в світі портативних пристроїв для роботи та розваг.',
                    'category_id' => $categories[1]->id,
                    'status' => 1,
                ],
            ];
            
            foreach ($posts as $postData) {
                $post = new Post();
                $post->title = $postData['title'];
                $post->content = $postData['content'];
                $post->category_id = $postData['category_id'];
                $post->author_id = $admin->id;
                $post->status = $postData['status'];
                $post->image = 'https://via.placeholder.com/800x400';
                
                if ($post->save()) {
                    $randomTags = array_rand($allTags, min(3, count($allTags)));
                    if (!is_array($randomTags)) {
                        $randomTags = [$randomTags];
                    }
                    
                    foreach ($randomTags as $tagIndex) {
                        $postTag = new \app\models\PostTag();
                        $postTag->post_id = $post->id;
                        $postTag->tag_id = $allTags[$tagIndex]->id;
                        $postTag->save();
                    }
                    
                    $this->stdout("Стаття '{$post->title}' створена\n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("\nБаза даних ініціалізована!\n", Console::FG_GREEN);
        return ExitCode::OK;
    }
}
