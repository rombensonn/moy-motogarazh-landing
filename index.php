<?php

declare(strict_types=1);

$config = require __DIR__ . '/config.php';
$business = $config['business'];
$siteUrl = rtrim((string) $config['site_url'], '/');
$assetVersion = '1.0.0';

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$services = [
    [
        'title' => 'ТО и сезонная подготовка',
        'what' => 'Комплексная проверка масла, фильтров, тормозов, цепи, света, крепежа и базовых узлов перед активными поездками.',
        'situations' => 'Для тех, кто открывает сезон, купил мотоцикл с рук, долго не ездил или хочет спокойно уехать в дальнюю поездку.',
        'why' => 'Смотрим технику целиком, объясняем приоритеты простым языком и не навязываем работы, которые можно отложить.',
    ],
    [
        'title' => 'Замена масла и фильтров',
        'what' => 'Подбор и аккуратная замена масла, масляного и воздушного фильтра с осмотром состояния расходников.',
        'situations' => 'Нужна по регламенту, после покупки техники, перед сезоном или если масло давно не менялось.',
        'why' => 'Работаем чисто, фиксируем внимание на утечках и даём понятную рекомендацию по следующему интервалу обслуживания.',
    ],
    [
        'title' => 'Тормоза и колодки',
        'what' => 'Замена колодок, проверка дисков, прокачка контуров и диагностика тормозной системы.',
        'situations' => 'Если увеличился тормозной путь, ручка стала мягкой, появился скрип, вибрация или колодки подходят к пределу.',
        'why' => 'Тормоза не терпят догадок: проверяем систему последовательно и согласуем каждую работу до ремонта.',
    ],
    [
        'title' => 'Ремонт суппортов',
        'what' => 'Разборка, очистка, оценка состояния поршней и уплотнений, сборка и проверка работы суппортов.',
        'situations' => 'Для случаев, когда колесо подклинивает, колодки стираются неравномерно или тормоза работают рывками.',
        'why' => 'Уделяем внимание мелочам, из-за которых проблема возвращается: грязь, закисание, износ резинок и неправильная сборка.',
    ],
    [
        'title' => 'Сцепление и привод',
        'what' => 'Регулировка сцепления, диагностика пробуксовки, замена сцепления, цепи, звёзд и сопутствующих деталей.',
        'situations' => 'Если передачи включаются грубо, сцепление буксует, цепь растянута или появились рывки при разгоне.',
        'why' => 'Сначала отличаем регулировку от реального износа, чтобы не менять узлы раньше времени.',
    ],
    [
        'title' => 'Вилка и подвеска',
        'what' => 'Переборка вилки, замена масла и сальников, проверка люфтов, состояния направляющих и работы подвески.',
        'situations' => 'Нужна при потёках масла, клевках при торможении, нестабильности в поворотах или после жёсткой эксплуатации.',
        'why' => 'Работа с подвеской требует аккуратности: разбираем, очищаем и собираем без спешки, с контролем состояния деталей.',
    ],
    [
        'title' => 'Регулировка клапанов',
        'what' => 'Проверка и настройка клапанных зазоров по модели техники с оценкой сопутствующих признаков износа.',
        'situations' => 'Актуально по пробегу, при сложном запуске, изменении звука двигателя или после покупки мотоцикла без истории.',
        'why' => 'Не ограничиваемся одной цифрой: смотрим контекст, чтобы владелец понимал, что происходит с мотором.',
    ],
    [
        'title' => 'Подшипники колёс',
        'what' => 'Диагностика люфтов, замена подшипников и проверка посадки, вращения и сопутствующих элементов.',
        'situations' => 'Если появился гул, биение, люфт, странная вибрация или техника готовится к сезону после хранения.',
        'why' => 'Проверяем не только сам подшипник, но и то, что могло привести к ускоренному износу.',
    ],
    [
        'title' => 'Полировка и восстановление фар',
        'what' => 'Полировка пластика и лакокрасочных элементов, восстановление прозрачности фар и внешнего вида техники.',
        'situations' => 'Подходит перед продажей, после сезона, при мутных фарах, мелких потёртостях и уставшем внешнем виде.',
        'why' => 'Делаем без агрессивного подхода: сохраняем материал и заранее объясняем, какой результат реалистичен.',
    ],
    [
        'title' => 'Ультразвуковая чистка',
        'what' => 'Глубокая очистка деталей и мелких узлов от загрязнений в ультразвуковой ванне без грубой механики.',
        'situations' => 'Нужна для деталей после долгого простоя, загрязнений, следов старого топлива, масла или труднодоступной грязи.',
        'why' => 'Метод помогает аккуратно добраться туда, где щётка и тряпка бессильны, особенно при восстановлении техники.',
    ],
];

$prices = [
    ['service' => 'Замена моторного масла', 'price' => 'от 1 500 ₽'],
    ['service' => 'Замена колодок', 'price' => 'от 1 000 ₽'],
    ['service' => 'Прокачка тормозной системы', 'price' => 'от 1 500 ₽'],
    ['service' => 'Ремонт суппортов', 'price' => 'от 3 000 ₽'],
    ['service' => 'Регулировка клапанов', 'price' => 'от 6 000 ₽'],
    ['service' => 'Переборка вилки', 'price' => 'от 10 000 ₽'],
    ['service' => 'Замена сцепления', 'price' => 'от 12 000 ₽'],
];

$steps = [
    ['title' => 'Описываете задачу', 'text' => 'Напишите модель, симптомы и желаемую дату. Можно сразу приложить фото или видео.'],
    ['title' => 'Согласуем диагностику', 'text' => 'Подскажем ориентир по работам, времени и расходникам до приезда.'],
    ['title' => 'Делаем и держим связь', 'text' => 'После осмотра согласуем объём работ и сообщим, когда техника готова.'],
];

$reviews = [
    ['author' => 'Дмитрий М.', 'text' => 'Отмечает комплексную подготовку к сезону, ровные колеса, тормоза и понятную цену.'],
    ['author' => 'Наталья П.', 'text' => 'Пишет, что мотоцикл привели в порядок: масло, детали, шины и работа с выхлопом.'],
    ['author' => 'Клим Морозов', 'text' => 'Хвалит внимательное отношение к технике и понятное объяснение по работам.'],
];

$gallery = [
    ['file' => 'yandex-photo-1', 'alt' => 'Мотосервис Мой Мотогараж в Зеленограде, рабочая зона'],
    ['file' => 'yandex-photo-2', 'alt' => 'Ремонт мототехники в мастерской Мой Мотогараж'],
    ['file' => 'yandex-photo-3', 'alt' => 'Мотоцикл на обслуживании в Мой Мотогараж'],
    ['file' => 'yandex-photo-4', 'alt' => 'Детали мототехники после обслуживания'],
    ['file' => 'yandex-photo-5', 'alt' => 'Рабочее место мотомеханика в Зеленограде'],
    ['file' => 'yandex-photo-6', 'alt' => 'Мототехника в сервисе Мой Мотогараж'],
    ['file' => 'yandex-photo-7', 'alt' => 'Фото мастерской Мой Мотогараж с Яндекс Карт'],
    ['file' => 'yandex-photo-8', 'alt' => 'Обслуживание мотоцикла в мотосервисе Зеленоград'],
];

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'AutoRepair',
    'name' => $business['name'],
    'image' => $siteUrl . '/images/yandex-photo-1.jpg',
    'url' => $siteUrl . '/',
    'telephone' => $business['phone_display'],
    'priceRange' => '₽₽',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Новокрюковская улица, 3Б',
        'addressLocality' => 'Зеленоград',
        'addressRegion' => 'Москва',
        'postalCode' => $business['postal_code'],
        'addressCountry' => 'RU',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => $business['latitude'],
        'longitude' => $business['longitude'],
    ],
    'openingHours' => ['Mo-Su 11:00-20:00'],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => $business['rating'],
        'ratingCount' => $business['rating_count'],
        'reviewCount' => $business['review_count'],
    ],
    'sameAs' => [$business['telegram_url'], $business['vk_url'], $business['yandex_url']],
];
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Мой Мотогараж — мотосервис в Зеленограде</title>
    <meta name="description" content="Мотосервис Мой Мотогараж в Зеленограде: ТО, ремонт, замена масла, тормоза, сцепление, вилка и подготовка к сезону. Рейтинг 4.9, ежедневно 11:00–20:00.">
    <link rel="canonical" href="<?= e($siteUrl) ?>/">
    <meta name="theme-color" content="#fbf7ef">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Мой Мотогараж — мотосервис в Зеленограде">
    <meta property="og:description" content="Ремонт и обслуживание мототехники на Новокрюковской ул., 3Б. Запись через Telegram или по телефону.">
    <meta property="og:url" content="<?= e($siteUrl) ?>/">
    <meta property="og:image" content="<?= e($siteUrl) ?>/images/yandex-photo-1.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;650;750;800;850;900&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="./images/yandex-photo-1.webp" type="image/webp">
    <link rel="stylesheet" href="./css/styles.css?v=<?= e($assetVersion) ?>">
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
    <a class="skip-link" href="#main">К содержанию</a>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="#top" aria-label="Мой Мотогараж">
                <span class="brand-mark" aria-hidden="true">ММ</span>
                <span>Мой Мотогараж</span>
            </a>
            <nav class="nav-links" aria-label="Основная навигация">
                <a href="#services">Услуги</a>
                <a href="#reviews">Отзывы</a>
                <a href="#contacts">Контакты</a>
            </nav>
            <div class="header-actions">
                <a class="link-action" href="tel:<?= e($business['phone_href']) ?>">Позвонить</a>
                <a class="button button-dark button-small" href="#lead">Записаться</a>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero" id="top">
            <div class="container hero-inner">
                <p class="eyebrow">Зеленоград · <?= e($business['hours']) ?></p>
                <h1>Мотосервис в Зеленограде, которому доверяют свою технику.</h1>
                <p class="hero-copy">Ремонт, ТО и подготовка к сезону для мотоциклов, эндуро и трициклов. Сначала разбираемся в задаче, потом согласуем работы и держим связь до выдачи.</p>
                <div class="hero-actions" aria-label="Быстрые действия">
                    <a class="button button-dark" href="<?= e($business['telegram_url']) ?>" target="_blank" rel="noopener">Записаться в Telegram</a>
                    <a class="button button-light" href="tel:<?= e($business['phone_href']) ?>">Позвонить</a>
                </div>
                <div class="hero-stage" aria-label="Ключевые факты о мотосервисе">
                    <div class="stage-gradient" aria-hidden="true"></div>
                    <article class="float-card float-card-large card-left">
                        <span class="card-kicker">Рейтинг на Яндекс Картах</span>
                        <strong><?= e($business['rating']) ?> из 5</strong>
                        <span><?= e($business['rating_count']) ?> оценок · <?= e($business['review_count']) ?> отзывов</span>
                    </article>
                    <article class="float-card float-card-compact card-center">
                        <span class="card-kicker">ТО</span>
                        <strong>от 1 500 ₽</strong>
                    </article>
                    <article class="float-card float-card-large card-right">
                        <span class="card-kicker">Адрес</span>
                        <strong>Новокрюковская 3Б</strong>
                        <span>Ежедневно 11:00–20:00</span>
                    </article>
                    <article class="float-card float-card-compact card-low">
                        <span class="card-kicker">Работы</span>
                        <strong>Тормоза · вилка · сцепление</strong>
                    </article>
                    <picture class="photo-chip photo-chip-a">
                        <source srcset="./images/yandex-photo-3.webp" type="image/webp">
                        <img src="./images/yandex-photo-3.jpg" alt="Мотоцикл на обслуживании в Мой Мотогараж" width="112" height="112">
                    </picture>
                    <picture class="photo-chip photo-chip-b">
                        <source srcset="./images/yandex-photo-4.webp" type="image/webp">
                        <img src="./images/yandex-photo-4.jpg" alt="Детали мототехники в мастерской" width="92" height="92">
                    </picture>
                    <picture class="photo-chip photo-chip-c">
                        <source srcset="./images/yandex-photo-6.webp" type="image/webp">
                        <img src="./images/yandex-photo-6.jpg" alt="Реальное фото мотосервиса с Яндекс Карт" width="80" height="80">
                    </picture>
                </div>
            </div>
        </section>

        <section class="section" id="services">
            <div class="container section-heading">
                <p class="eyebrow">Услуги</p>
                <h2>Сразу выберите задачу: что делаем, когда это нужно и почему у нас.</h2>
                <p>Второй блок ведёт по логике владельца: сначала понять свою ситуацию, затем выбрать услугу и быстро перейти к записи.</p>
            </div>
            <div class="container service-grid">
                <?php foreach ($services as $index => $service): ?>
                    <article class="service-card">
                        <div class="service-card-header">
                            <span class="service-number"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="service-label">Мотосервис</span>
                        </div>
                        <h3><?= e($service['title']) ?></h3>
                        <div class="service-detail-list">
                            <div>
                                <span>Что за услуга</span>
                                <p><?= e($service['what']) ?></p>
                            </div>
                            <div>
                                <span>Для кого и когда</span>
                                <p><?= e($service['situations']) ?></p>
                            </div>
                            <div>
                                <span>Почему у нас</span>
                                <p><?= e($service['why']) ?></p>
                            </div>
                        </div>
                        <a class="service-cta" href="#lead" data-service="<?= e($service['title']) ?>">Обсудить услугу</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section section-soft">
            <div class="container trust-layout">
                <div class="trust-media">
                    <picture>
                        <source srcset="./images/yandex-photo-1.webp" type="image/webp">
                        <img src="./images/yandex-photo-1.jpg" alt="Мотосервис Мой Мотогараж, рабочая зона в Зеленограде" width="1024" height="577" loading="lazy">
                    </picture>
                </div>
                <div class="trust-copy">
                    <p class="eyebrow">Почему приезжают</p>
                    <h2>Без лишнего шума: понятные работы, связь по делу и реальная мастерская.</h2>
                    <div class="proof-list">
                        <div>
                            <strong>4.9</strong>
                            <span>рейтинг на Яндекс Картах</span>
                        </div>
                        <div>
                            <strong>64</strong>
                            <span>фото и материалы в карточке бизнеса</span>
                        </div>
                        <div>
                            <strong>7/7</strong>
                            <span>работаем ежедневно с 11:00 до 20:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="prices">
            <div class="container section-heading">
                <p class="eyebrow">Цены</p>
                <h2>Ориентиры “от”, чтобы быстро понять порядок работ.</h2>
                <p>Финальная стоимость зависит от модели, состояния узлов и расходников. Перед ремонтом согласуем объём и цену.</p>
            </div>
            <div class="container price-board">
                <?php foreach ($prices as $price): ?>
                    <div class="price-row">
                        <span><?= e($price['service']) ?></span>
                        <strong><?= e($price['price']) ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section section-gradient">
            <div class="container section-heading">
                <p class="eyebrow">Как записаться</p>
                <h2>Три шага от сообщения до готовой техники.</h2>
            </div>
            <div class="container process-grid">
                <?php foreach ($steps as $index => $step): ?>
                    <article class="process-card">
                        <span><?= $index + 1 ?></span>
                        <h3><?= e($step['title']) ?></h3>
                        <p><?= e($step['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section" id="reviews">
            <div class="container section-heading">
                <p class="eyebrow">Отзывы</p>
                <h2>Клиенты чаще всего отмечают внимание к деталям и понятные цены.</h2>
                <p>Короткая выжимка из отзывов на Яндекс Картах. Полные отзывы открываются в карточке бизнеса.</p>
            </div>
            <div class="container reviews-grid">
                <?php foreach ($reviews as $review): ?>
                    <article class="review-card">
                        <div class="stars" aria-label="Оценка 5 из 5">★★★★★</div>
                        <p>“<?= e($review['text']) ?>”</p>
                        <strong><?= e($review['author']) ?></strong>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="container center-action">
                <a class="button button-light" href="<?= e($business['yandex_url']) ?>" target="_blank" rel="noopener">Смотреть отзывы на Яндекс Картах</a>
            </div>
        </section>

        <section class="section section-soft" id="gallery">
            <div class="container section-heading">
                <p class="eyebrow">Фото</p>
                <h2>Реальные снимки мастерской с Яндекс Карт.</h2>
            </div>
            <div class="container gallery-grid">
                <?php foreach ($gallery as $index => $image): ?>
                    <a class="gallery-item" href="./images/<?= e($image['file']) ?>.jpg" target="_blank" rel="noopener">
                        <picture>
                            <source srcset="./images/<?= e($image['file']) ?>.webp" type="image/webp">
                            <img src="./images/<?= e($image['file']) ?>.jpg" alt="<?= e($image['alt']) ?>" width="640" height="480" loading="<?= $index === 0 ? 'eager' : 'lazy' ?>">
                        </picture>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section">
            <div class="container faq-layout">
                <div>
                    <p class="eyebrow">FAQ</p>
                    <h2>Перед записью обычно спрашивают это.</h2>
                </div>
                <div class="faq-list">
                    <details>
                        <summary>Можно приехать без записи?</summary>
                        <p>Лучше заранее написать или позвонить: так мастерская подготовит окно и не заставит ждать.</p>
                    </details>
                    <details>
                        <summary>Можно ли прислать видео с проблемой?</summary>
                        <p>Да. Видео со звуком, фото узла и модель техники помогут быстрее сориентироваться по диагностике.</p>
                    </details>
                    <details>
                        <summary>Работаете с эндуро?</summary>
                        <p>Да, в карточке бизнеса указана работа с эндуро и другой мототехникой.</p>
                    </details>
                    <details>
                        <summary>Когда понятна итоговая цена?</summary>
                        <p>После осмотра и согласования работ. На сайте указаны стартовые цены “от”.</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="section contact-section" id="contacts">
            <div class="container contact-layout">
                <div class="contact-copy">
                    <p class="eyebrow">Контакты</p>
                    <h2>Запишите технику на удобное время.</h2>
                    <p>Напишите в Telegram, позвоните или оставьте короткую заявку. Чем подробнее опишете задачу, тем точнее будет первичный ориентир.</p>
                    <div class="contact-list">
                        <a href="tel:<?= e($business['phone_href']) ?>">
                            <span>Телефон</span>
                            <strong><?= e($business['phone_display']) ?></strong>
                        </a>
                        <a href="<?= e($business['telegram_url']) ?>" target="_blank" rel="noopener">
                            <span>Telegram</span>
                            <strong><?= e($business['telegram_label']) ?></strong>
                        </a>
                        <a href="<?= e($business['route_url']) ?>" target="_blank" rel="noopener">
                            <span>Адрес</span>
                            <strong><?= e($business['address_short']) ?></strong>
                        </a>
                        <a href="<?= e($business['vk_url']) ?>" target="_blank" rel="noopener">
                            <span>VK</span>
                            <strong>my.motogarage</strong>
                        </a>
                    </div>
                </div>
                <form class="lead-form" id="lead" action="./api/lead.php" method="post" novalidate>
                    <input type="hidden" name="form_source" value="contact_section">
                    <input type="hidden" name="utm_source" value="">
                    <input type="hidden" name="utm_medium" value="">
                    <input type="hidden" name="utm_campaign" value="">
                    <label class="honeypot" aria-hidden="true">
                        <span>Не заполняйте это поле</span>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </label>
                    <div class="form-row">
                        <label for="name">Имя</label>
                        <input id="name" name="name" type="text" autocomplete="name" placeholder="Как к вам обращаться">
                    </div>
                    <div class="form-row">
                        <label for="phone">Телефон</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" placeholder="+7 999 000-00-00" required>
                        <span class="field-error" data-error-for="phone"></span>
                    </div>
                    <div class="form-row">
                        <label for="bike">Техника</label>
                        <input id="bike" name="bike" type="text" placeholder="Например: Yamaha MT-07">
                    </div>
                    <div class="form-row">
                        <label for="service">Что нужно сделать</label>
                        <select id="service" name="service">
                            <option value="">Выберите услугу</option>
                            <option>ТО и сезонная подготовка</option>
                            <option>Замена масла и фильтров</option>
                            <option>Тормоза и колодки</option>
                            <option>Ремонт суппортов</option>
                            <option>Сцепление и привод</option>
                            <option>Вилка и подвеска</option>
                            <option>Регулировка клапанов</option>
                            <option>Подшипники колёс</option>
                            <option>Полировка и восстановление фар</option>
                            <option>Ультразвуковая чистка</option>
                            <option>Другое</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="message">Комментарий</label>
                        <textarea id="message" name="message" rows="4" placeholder="Опишите симптомы, желаемую дату или вопрос"></textarea>
                    </div>
                    <button class="button button-dark form-submit" type="submit">Отправить заявку</button>
                    <p class="form-status" role="status" aria-live="polite"></p>
                    <p class="form-fallback">Если форма недоступна: <a href="tel:<?= e($business['phone_href']) ?>">позвоните</a> или <a href="<?= e($business['telegram_url']) ?>" target="_blank" rel="noopener">напишите в Telegram</a>.</p>
                </form>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <strong><?= e($business['name']) ?></strong>
                <span><?= e($business['legal_type']) ?> · <?= e($business['address_short']) ?></span>
            </div>
            <div>
                <a href="<?= e($business['yandex_url']) ?>" target="_blank" rel="noopener">Яндекс Карты</a>
                <a href="<?= e($business['route_url']) ?>" target="_blank" rel="noopener">Маршрут</a>
            </div>
        </div>
    </footer>

    <nav class="mobile-actions" aria-label="Быстрые действия">
        <a href="tel:<?= e($business['phone_href']) ?>">Позвонить</a>
        <a href="<?= e($business['telegram_url']) ?>" target="_blank" rel="noopener">Telegram</a>
        <a href="<?= e($business['route_url']) ?>" target="_blank" rel="noopener">Маршрут</a>
    </nav>

    <script src="./js/main.js?v=<?= e($assetVersion) ?>" defer></script>
</body>
</html>
