<?php

namespace App\Tools;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class ApaPtBr
{
    public static function register()
    {
        Str::macro('apaPtBr', function ($string) {
            if (trim($string) === '') {
                return $string;
            }
            $minorWords = [
                'a',
                'à',
                'às',
                'o',
                'os',
                'as',
                'um',
                'uma',
                'uns',
                'umas',
                'de',
                'do',
                'da',
                'dos',
                'das',
                'em',
                'no',
                'na',
                'nos',
                'nas',
                'por',
                'pelo',
                'pela',
                'pelos',
                'pelas',
                'para',
                'per',
                'perante',
                'com',
                'sem',
                'sob',
                'sobre',
                'entre',
                'até',
                'após',
                'antes',
                'desde',
                'e',
                'ou',
                'mas',
                'nem',
                'se',
                'então',
                'via',
                'acima',
                'et',
                'un',
                'une',
                'la',
                'le',
                'les',
                'du',
                'des',
                'par',
            ];

            $endPunctuation = ['.', '!', '?', ':', '—', ','];

            $words = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);

            for ($i = 0; $i < count($words); $i++) {
                $lowercaseWord = mb_strtolower($words[$i]);

                if (str_contains($lowercaseWord, '-')) {
                    $hyphenatedWords = explode('-', $lowercaseWord);

                    $hyphenatedWords = array_map(function ($part) use ($minorWords) {
                        return (in_array($part, $minorWords) && mb_strlen($part) <= 3)
                            ? $part
                            : mb_strtoupper(mb_substr($part, 0, 1)) . mb_substr($part, 1);
                    }, $hyphenatedWords);

                    $words[$i] = implode('-', $hyphenatedWords);
                } else {
                    if (
                        in_array($lowercaseWord, $minorWords) &&
                        mb_strlen($lowercaseWord) <= 3 &&
                        !($i === 0 || in_array(mb_substr($words[$i - 1], -1), $endPunctuation))
                    ) {
                        $words[$i] = $lowercaseWord;
                    } else {
                        $words[$i] = mb_strtoupper(mb_substr($lowercaseWord, 0, 1)) . mb_substr($lowercaseWord, 1);
                    }
                }
            }

            return implode(' ', $words);
        });

        Stringable::macro('apaPtBr', function (string $string) {
            return new Stringable(Str::apaPtBr($string));
        });
    }
}
