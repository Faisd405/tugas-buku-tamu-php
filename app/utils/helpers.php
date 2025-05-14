<?php


function formatDate($date)
{
    return date('d F Y', strtotime($date));
}


function formatTime($time)
{
    return date('H:i', strtotime($time));
}


function showAlert($message, $type = 'info')
{
    $icon = '';

    switch ($type) {
        case 'success':
            $icon = '<i class="fas fa-check-circle"></i>';
            break;
        case 'danger':
            $icon = '<i class="fas fa-exclamation-triangle"></i>';
            break;
        case 'warning':
            $icon = '<i class="fas fa-exclamation-circle"></i>';
            break;
        default:
            $icon = '<i class="fas fa-info-circle"></i>';
    }

    return '<div class="alert alert-' . $type . '" role="alert">
                ' . $icon . ' ' . $message . '
            </div>';
}


function redirect($url)
{
    header('Location: ' . $url);
    exit();
}
