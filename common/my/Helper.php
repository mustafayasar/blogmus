<?php

namespace common\my;

use Yii;


class Helper
{
    static public function slugify($str, $limit = null)
    {
        try {
            // Make sure string is in UTF-8 and strip invalid UTF-8 characters
            $str        = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

            $options    = [
                'delimiter'     => '-',
                'limit'         => $limit,
                'lowercase'     => true,
                'replacements'  => [],
                'transliterate' => true,
            ];

            $char_map = array(
                // Ekstra
                "'" => '',
                // My Add
                'ă' => 'a', 'ė' => 'e', 'œ' => 'oe', 'đ' => 'd', 'ō' => 'o', 'ũ' => 'u', 'º' => 'o', '°' => 'o',
                'ª' => 'a', 'Đ' => 'D', 'Š' => 'S', 'Ă' => 'A', 'Ș' => 'S', 'ș' => 's', 'ț' => 't', 'Œ' => 'oe',
                'Ľ' => 'L', 'ų' => 'u', 'Ţ' => 'T', 'ţ' => 't', 'Ė' => 'E', 'ş' => 's', 'Ç' => 'C',
                'Ö' => 'O', 'ü' => 'u', 'İ' => 'I', 'ç' => 'c', 'Ü' => 'U', 'ğ' => 'g', 'ö' => 'ö', 'Ş' => 'S',
                // Latin
                'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
                'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
                'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
                'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
                'ß' => 'ss',
                'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
                'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
                'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
                'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
                'ÿ' => 'y',
                // Latin symbols
                '©' => '-',
                // Greek
                'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
                'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
                'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
                'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
                'Ϋ' => 'Y',
                'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
                'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
                'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
                'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
                'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
                // Turkish
                'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
                'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
                // Russian
                'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
                'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
                'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
                'Я' => 'Ya',
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
                'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
                'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
                'я' => 'ya',
                // Ukrainian
                'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
                'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
                // Czech
                'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
                'Ž' => 'Z',
                'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
                'ž' => 'z',
                // Polish
                'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
                'Ż' => 'Z',
                'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
                'ż' => 'z',
                // Latvian
                'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
                'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
                'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
                'š' => 's', 'ū' => 'u', 'ž' => 'z'
            );

            // Make custom replacements
            $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

            // Transliterate characters to ASCII
            if ($options['transliterate']) {
                $str = str_replace(array_keys($char_map), $char_map, $str);
            }

            // Replace non-alphanumeric characters with our delimiter
            $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

            // Remove duplicate delimiters
            $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

            // Truncate slug to max. characters
            $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

            // Remove delimiter from ends
            $str = trim($str, $options['delimiter']);

            return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
        } catch (Exception $e) {

            return '';
        }
    }

    public static $months = array(
        '01' => 'Ocak',
        '02' => 'Şubat',
        '03' => 'Mart',
        '04' => 'Nisan',
        '05' => 'Mayıs',
        '06' => 'Haziran',
        '07' => 'Temmuz',
        '08' => 'Ağustos',
        '09' => 'Eylül',
        '10' => 'Ekim',
        '11' => 'Kasım',
        '12' => 'Aralık'
    );

    public static function getDate($datetime, $type = 'main')
    {
        if ($type == 'main' || $type == 'with_time') {
            $at         = time() - strtotime($datetime);
            $at_second  = $at;
            $at_minute  = round($at/60);
            $at_hour    = round($at/(60*60));
            $at_day     = round($at/(60*60*24));

            if ($at_second < 60) {
                return $at_second.' saniye önce';
            } elseif ($at_minute < 60) {
                return $at_minute.' dakika önce';
            } elseif($at_hour < 24) {
                return $at_hour.' saat önce';
            } elseif($at_day < 30) {
                return $at_day.' gün önce';
            } else {
                $dt     = explode(" ", $datetime);
                $date   = $dt[0];
                $time   = $dt[1];
                $ymd    = explode("-", $date);
                $year   = $ymd[0];
                $month  = $ymd[1];
                $day    = $ymd[2];
                $his    = explode(":", $time);
                $hour   = $his[0];
                $minute = $his[1];

                if ($type == 'with_time') {
                    return $day." ".self::$months[$month]." ".$year." ".$hour.":".$minute;
                }

                return $day." ".self::$months[$month]." ".$year;
            }
        }

        return $datetime;
    }

    public static function strposArr($haystack, $needle) {
        if (!is_array($needle)) $needle = array($needle);

        foreach ($needle as $what) {
            if(strpos($haystack, $what) !== false) return true;
        }

        return false;
    }

    public static function striposArr($haystack, $needle) {
        if (!is_array($needle)) $needle = array($needle);

        foreach ($needle as $what) {
            if(stripos($haystack, $what) !== false) return true;
        }

        return false;
    }
}