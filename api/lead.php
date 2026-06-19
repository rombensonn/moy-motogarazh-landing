<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Метод не поддерживается'], JSON_UNESCAPED_UNICODE);
    exit;
}

$config = require __DIR__ . '/../config.php';

function respond(bool $ok, string $error = '', int $status = 200): never
{
    http_response_code($status);
    echo json_encode($ok ? ['ok' => true] : ['ok' => false, 'error' => $error], JSON_UNESCAPED_UNICODE);
    exit;
}

function field(string $key, int $limit = 500): string
{
    $value = trim((string) ($_POST[$key] ?? ''));
    $value = preg_replace('/\s+/u', ' ', $value) ?? '';
    return mb_substr($value, 0, $limit);
}

function logLead(array $payload): void
{
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0775, true);
    }

    $payload['logged_at'] = date(DATE_ATOM);
    file_put_contents(
        $logDir . '/leads.log',
        json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}

if (field('website', 120) !== '') {
    logLead(['status' => 'blocked_honeypot', 'ip' => $_SERVER['REMOTE_ADDR'] ?? null]);
    respond(true);
}

$name = field('name', 80);
$phone = field('phone', 40);
$bike = field('bike', 120);
$service = field('service', 120);
$message = field('message', 700);
$formSource = field('form_source', 80);

$phoneDigits = preg_replace('/\D+/', '', $phone) ?? '';
if (strlen($phoneDigits) < 10) {
    respond(false, 'Укажите телефон для связи', 422);
}

$utm = [
    'utm_source' => field('utm_source', 120),
    'utm_medium' => field('utm_medium', 120),
    'utm_campaign' => field('utm_campaign', 120),
];

$lead = [
    'status' => 'received',
    'name' => $name !== '' ? $name : 'Не указано',
    'phone' => $phone,
    'bike' => $bike !== '' ? $bike : 'Не указано',
    'service' => $service !== '' ? $service : 'Не выбрано',
    'message' => $message !== '' ? $message : 'Без комментария',
    'form_source' => $formSource !== '' ? $formSource : 'landing',
    'utm' => array_filter($utm),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
];

$telegram = $config['telegram'] ?? [];
$botToken = (string) ($telegram['bot_token'] ?? '');
$chatId = (string) ($telegram['chat_id'] ?? '');

if ($botToken === '' || $chatId === '') {
    $lead['status'] = 'telegram_not_configured';
    logLead($lead);
    respond(false, 'Заявка не отправлена: Telegram пока не настроен. Позвоните или напишите нам напрямую.', 503);
}

$lines = [
    'Новая заявка с лендинга',
    '',
    'Имя: ' . $lead['name'],
    'Телефон: ' . $lead['phone'],
    'Мотоцикл: ' . $lead['bike'],
    'Услуга: ' . $lead['service'],
    'Комментарий: ' . $lead['message'],
    'Форма: ' . $lead['form_source'],
];

if ($lead['utm'] !== []) {
    $lines[] = 'UTM: ' . http_build_query($lead['utm'], '', ', ');
}

$telegramUrl = 'https://api.telegram.org/bot' . rawurlencode($botToken) . '/sendMessage';
$body = http_build_query([
    'chat_id' => $chatId,
    'text' => implode("\n", $lines),
    'disable_web_page_preview' => '1',
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $body,
        'timeout' => 8,
        'ignore_errors' => true,
    ],
]);

$result = @file_get_contents($telegramUrl, false, $context);
$decoded = is_string($result) ? json_decode($result, true) : null;

if (!is_array($decoded) || ($decoded['ok'] ?? false) !== true) {
    $lead['status'] = 'telegram_error';
    $lead['telegram_response'] = is_string($result) ? mb_substr($result, 0, 1000) : null;
    logLead($lead);
    respond(false, 'Не удалось отправить заявку. Позвоните или напишите в Telegram, мы быстро ответим.', 502);
}

$lead['status'] = 'sent';
logLead($lead);
respond(true);
