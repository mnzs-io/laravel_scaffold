<?php

namespace App\Tools;

class FlashMessage
{
    private static function message(string $level, string $message, string $title, $durationInSeconds)
    {
        session()->flash(
            'flash-message',
            $level . '###' . $message . '###' . $title . '###' . $durationInSeconds * 1000 . '###' . now()->timestamp,
        );
    }

    public static function success(string $message, $title = 'Sucesso', $durationInSeconds = 5)
    {
        self::message('success', $message, $title, $durationInSeconds);
    }

    public static function info(string $message, $title = 'Informação', $durationInSeconds = 5)
    {
        self::message('info', $message, $title, $durationInSeconds);
    }

    public static function warning(string $message, $title = 'Atenção:', $durationInSeconds = 5)
    {
        self::message('warning', $message, $title, $durationInSeconds);
    }

    public static function error(string $message, $title = 'Erro', $durationInSeconds = 5)
    {
        self::message('error', $message, $title, $durationInSeconds);
    }

    public static function neutral(string $message, $title = 'Mensagem de Sistema', $durationInSeconds = 5)
    {
        self::message('neutral', $message, $title, $durationInSeconds);
    }
}
