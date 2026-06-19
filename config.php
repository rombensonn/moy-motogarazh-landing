<?php

declare(strict_types=1);

$config = [
    'site_url' => rtrim((string) (getenv('SITE_URL') ?: 'https://rombensonn.github.io/moy-motogarazh-landing'), '/'),
    'telegram' => [
        'bot_token' => (string) (getenv('TG_BOT_TOKEN') ?: ''),
        'chat_id' => (string) (getenv('TG_CHAT_ID') ?: ''),
    ],
    'business' => [
        'name' => 'Мой Мотогараж',
        'legal_type' => 'Мотосервис',
        'phone_display' => '+7 (985) 202-20-24',
        'phone_href' => '+79852022024',
        'telegram_url' => 'https://t.me/My_Motogarage',
        'telegram_label' => '@My_Motogarage',
        'vk_url' => 'https://vk.com/my.motogarage',
        'yandex_url' => 'https://yandex.ru/maps/org/moy_motogarazh/52787974921/',
        'route_url' => 'https://yandex.ru/maps/-/CTA1qQ8f',
        'address' => 'Москва, Зеленоград, Новокрюковская улица, 3Б',
        'address_short' => 'Новокрюковская ул., 3Б, Зеленоград',
        'postal_code' => '124617',
        'hours' => 'ежедневно, 11:00–20:00',
        'rating' => '4.9',
        'rating_count' => 25,
        'review_count' => 20,
        'latitude' => 55.98889,
        'longitude' => 37.159078,
    ],
];

$localConfigPath = __DIR__ . '/config.local.php';
if (is_file($localConfigPath)) {
    $localConfig = require $localConfigPath;
    if (is_array($localConfig)) {
        $config = array_replace_recursive($config, $localConfig);
    }
}

return $config;
