<?php

return [
    [
        'id' => 1,
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password_hash' => \Yii::$app->security->generatePasswordHash('admin123'),
        'status' => \app\models\User::STATUS_ACTIVE,
        'is_admin' => 1,
        'created_at' => time(),
        'updated_at' => time(),
    ],
    [
        'id' => 2,
        'username' => 'user1',
        'email' => 'user1@example.com',
        'password_hash' => \Yii::$app->security->generatePasswordHash('password123'),
        'status' => \app\models\User::STATUS_ACTIVE,
        'is_admin' => 0,
        'created_at' => time(),
        'updated_at' => time(),
    ],
    [
        'id' => 3,
        'username' => 'user2',
        'email' => 'user2@example.com',
        'password_hash' => \Yii::$app->security->generatePasswordHash('password123'),
        'status' => \app\models\User::STATUS_ACTIVE,
        'is_admin' => 0,
        'created_at' => time(),
        'updated_at' => time(),
    ],
];
