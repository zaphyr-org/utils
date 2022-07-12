<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * Class Str
 *
 * @package Zaphyr\Utils
 * @author  merloxx <merloxx@zaphyr.org>
 */
class Str
{
    /**
     * @const string
     */
    public const ENCODING = 'UTF-8';

    /**
     * @var array<string, array<string>>
     */
    protected static $chars = [
        // @formatter:off
        '0' => ['°', '₀', '۰', '０'],
        '1' => ['¹', '₁', '۱', '１'],
        '2' => ['²', '₂', '۲', '２'],
        '3' => ['³', '₃', '۳', '３'],
        '4' => ['⁴', '₄', '۴', '٤', '４'],
        '5' => ['⁵', '₅', '۵', '٥', '５'],
        '6' => ['⁶', '₆', '۶', '٦', '６'],
        '7' => ['⁷', '₇', '۷', '７'],
        '8' => ['⁸', '₈', '۸', '８'],
        '9' => ['⁹', '₉', '۹', '９'],
        'a' => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'],
        'b' => ['б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ', 'ｂ'],
        'c' => ['ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'],
        'd' => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'],
        'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'],
        'f' => ['ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'],
        'g' => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'],
        'h' => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'],
        'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'],
        'j' => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'],
        'k' => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'],
        'l' => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'],
        'm' => ['м', 'μ', 'م', 'မ', 'მ', 'ｍ'],
        'n' => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'],
        'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'],
        'p' => ['п', 'π', 'ပ', 'პ', 'پ', 'ｐ'],
        'q' => ['ყ', 'ｑ'],
        'r' => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'],
        's' => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'],
        't' => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'],
        'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'],
        'v' => ['в', 'ვ', 'ϐ', 'ｖ'],
        'w' => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'],
        'x' => ['χ', 'ξ', 'ｘ'],
        'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'],
        'z' => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'],
        'aa' => ['ع', 'आ', 'آ'],
        'ae' => ['æ', 'ǽ'],
        'ai' => ['ऐ'],
        'at' => ['@'],
        'ch' => ['ч', 'ჩ', 'ჭ', 'چ'],
        'dj' => ['ђ', 'đ'],
        'dz' => ['џ', 'ძ'],
        'ei' => ['ऍ'],
        'gh' => ['غ', 'ღ'],
        'ii' => ['ई'],
        'ij' => ['ĳ'],
        'kh' => ['х', 'خ', 'ხ'],
        'lj' => ['љ'],
        'nj' => ['њ'],
        'oe' => ['œ', 'ؤ'],
        'oi' => ['ऑ'],
        'oii' => ['ऒ'],
        'ps' => ['ψ'],
        'sh' => ['ш', 'შ', 'ش'],
        'shch' => ['щ'],
        'ss' => ['ß'],
        'sx' => ['ŝ'],
        'th' => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
        'ts' => ['ц', 'ც', 'წ'],
        'uu' => ['ऊ'],
        'ya' => ['я'],
        'yu' => ['ю'],
        'zh' => ['ж', 'ჟ', 'ژ'],
        '(c)' => ['©'],
        'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'],
        'B' => ['Б', 'Β', 'ब', 'Ｂ'],
        'C' => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'],
        'D' => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'],
        'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'],
        'F' => ['Ф', 'Φ', 'Ｆ'],
        'G' => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'],
        'H' => ['Η', 'Ή', 'Ħ', 'Ｈ'],
        'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'],
        'J' => ['Ｊ'],
        'K' => ['К', 'Κ', 'Ｋ'],
        'L' => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'],
        'M' => ['М', 'Μ', 'Ｍ'],
        'N' => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'],
        'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'],
        'P' => ['П', 'Π', 'Ｐ'],
        'Q' => ['Ｑ'],
        'R' => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'],
        'S' => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'],
        'T' => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'],
        'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'],
        'V' => ['В', 'Ｖ'],
        'W' => ['Ω', 'Ώ', 'Ŵ', 'Ｗ'],
        'X' => ['Χ', 'Ξ', 'Ｘ'],
        'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'],
        'Z' => ['Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'],
        'AE' => ['Æ', 'Ǽ'],
        'Ch' => ['Ч'],
        'Dj' => ['Ђ'],
        'Dz' => ['Џ'],
        'Gx' => ['Ĝ'],
        'Hx' => ['Ĥ'],
        'Ij' => ['Ĳ'],
        'Jx' => ['Ĵ'],
        'Kh' => ['Х'],
        'Lj' => ['Љ'],
        'Nj' => ['Њ'],
        'Oe' => ['Œ'],
        'Ps' => ['Ψ'],
        'Sh' => ['Ш'],
        'Shch' => ['Щ'],
        'Ss' => ['ẞ'],
        'Th' => ['Þ'],
        'Ts' => ['Ц'],
        'Ya' => ['Я'],
        'Yu' => ['Ю'],
        'Zh' => ['Ж'],
        ' ' => ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80", "\xEF\xBE\xA0"],
        // @formatter:on
    ];

    /**
     * @param string $string
     *
     * @return string|null
     */
    public static function toAscii(string $string): ?string
    {
        foreach (static::$chars as $key => $value) {
            $string = str_replace($value, $key, $string);
        }

        return preg_replace('/[^\x20-\x7E]/u', '', $string);
    }

    /**
     * @param string $string
     *
     * @return array<mixed>
     */
    public static function toArray(string $string): array
    {
        $array = [];
        $strlen = static::length($string);

        while ($strlen) {
            $array[] = static::subString($string, 0, 1);
            $string = static::subString($string, 1, $strlen);
            $strlen = static::length($string);
        }

        return $array;
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public static function toBool(string $string): bool
    {
        $string = static::lower($string);

        $map = [
            'true' => true,
            'false' => false,
            '1' => true,
            '0' => false,
            'on' => true,
            'off' => false,
            'yes' => true,
            'no' => false,
        ];

        if (array_key_exists($string, $map)) {
            return $map[$string];
        }

        return (bool)static::stripWhitespace($string);
    }

    /**
     * @param string          $haystack
     * @param string[]|string $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function beginsWith(string $haystack, $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && static::stringPos($haystack, $needle, 0, $caseSensitive) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string          $haystack
     * @param string[]|string $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function endsWith(string $haystack, $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            $end = static::length($haystack) - static::length($needle);

            if (static::stringPosReverse($haystack, $needle, 0, $caseSensitive) === $end) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string          $haystack
     * @param string[]|string $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function contains(string $haystack, $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && static::stringPos($haystack, $needle, 0, $caseSensitive) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string   $haystack
     * @param string[] $needles
     * @param bool     $caseSensitive
     *
     * @return bool
     */
    public static function containsAll(string $haystack, array $needles, bool $caseSensitive = true): bool
    {
        foreach ($needles as $needle) {
            if (!static::contains($haystack, $needle, $caseSensitive)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lower(string $string): string
    {
        return mb_strtolower($string, static::ENCODING);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lowerFirst(string $string): string
    {
        $first = static::subString($string, 0, 1);

        return static::lower($first) . static::subString($string, 1);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function upper(string $string): string
    {
        return mb_strtoupper($string, static::ENCODING);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function upperFirst(string $string): string
    {
        $first = static::subString($string, 0, 1);

        return static::upper($first) . static::subString($string, 1);
    }

    /**
     * @param string $string
     * @param int    $length
     * @param string $append
     *
     * @return string
     */
    public static function limit(string $string, int $length = 150, string $append = '...'): string
    {
        if ($length >= static::length($string)) {
            return $string;
        }

        $string = static::subString($string, 0, $length);

        return rtrim($string) . $append;
    }

    /**
     * @param string $string
     * @param int    $length
     * @param string $append
     *
     * @return string
     */
    public static function limitSafe(string $string, int $length = 150, string $append = '...'): string
    {
        if ($length >= static::length($string)) {
            return $string;
        }

        $truncated = static::subString($string, 0, $length);

        if (static::stringPos($string, ' ', $length - 1) !== $length) {
            $lastPos = static::stringPosReverse($truncated, ' ');

            if ($lastPos !== false) {
                $truncated = static::subString($truncated, 0, $lastPos);
            }
        }

        return rtrim($truncated) . $append;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function firstPos(string $haystack, string $needle, int $offset = 0, bool $caseSensitive = true)
    {
        if ($needle === '') {
            return false;
        }

        return static::stringPos($haystack, $needle, $offset, $caseSensitive);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function lastPos(string $haystack, string $needle, int $offset = 0, bool $caseSensitive = true)
    {
        return static::stringPosReverse($haystack, $needle, $offset, $caseSensitive);
    }

    /**
     * @param string $string
     * @param string $pattern
     * @param string $replacement
     * @param string $option
     *
     * @return string|null
     */
    public static function replace(
        string $string,
        string $pattern,
        string $replacement,
        string $option = 'msr'
    ): ?string {
        mb_regex_encoding(static::ENCODING);

        $result = mb_ereg_replace($pattern, $replacement, $string, $option);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string $string
     *
     * @return string|null
     */
    public static function stripWhitespace(string $string): ?string
    {
        return static::replace($string, '\s+', '');
    }

    /**
     * @param string $string
     * @param string $substring
     * @param int    $index
     *
     * @return string
     */
    public static function insert(string $string, string $substring, int $index): string
    {
        $length = static::length($string);

        if ($length < $index) {
            return $string;
        }

        $start = static::subString($string, 0, $index);
        $end = static::subString($string, $index, $length);

        return $start . $substring . $end;
    }

    /**
     * @param string $string1
     * @param string $string2
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    public static function equals(string $string1, string $string2, bool $caseSensitive = true): bool
    {
        if ($caseSensitive) {
            return strcmp($string1, $string2) === 0;
        }

        return strcasecmp($string1, $string2) === 0;
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function length(string $string): int
    {
        return mb_strlen($string, static::ENCODING);
    }

    /**
     * @param string $string
     * @param int    $flag
     * @param bool   $doubleEncode
     *
     * @return string
     */
    public static function escape(string $string, int $flag = ENT_QUOTES, bool $doubleEncode = true): string
    {
        return htmlspecialchars($string, $flag, static::ENCODING, $doubleEncode);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function title(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, static::ENCODING);
    }

    /**
     * @param string $string
     * @param string $delimiter
     *
     * @return string
     */
    public static function slug(string $string, string $delimiter = '-'): string
    {
        // Transliterate string
        $slug = (string)static::toAscii($string);

        // Replace non letters or digits with $delimiter
        $slug = (string)preg_replace('/[^A-Za-z0-9-]+/', $delimiter, $slug);

        // Remove $delimiter before and after string
        $slug = trim($slug, $delimiter);

        // Remove duplicate $delimiter
        $slug = (string)preg_replace('~' . $delimiter . '+~', $delimiter, $slug);

        // Lowercase string
        return static::lower($slug);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function studly(string $string): string
    {
        $string = str_replace(['-', '_'], ' ', $string);
        $string = static::title($string);

        return str_replace(' ', '', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function camel(string $string): string
    {
        $string = static::studly($string);

        return static::lowerFirst($string);
    }

    /**
     * @param string $string
     * @param string $delimiter
     *
     * @return string|null
     */
    public static function snake(string $string, string $delimiter = '_'): ?string
    {
        $string = (string)static::replace($string, '\B([A-Z])', '-\1');
        $string = static::lower($string);

        return static::replace($string, '[-_\s]+', $delimiter);
    }

    /**
     * @param string   $string
     * @param int      $start
     * @param int|null $length
     *
     * @return string
     */
    public static function subString(string $string, int $start = 0, int $length = null): string
    {
        return mb_substr($string, $start, $length, static::ENCODING);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function stringPos(string $haystack, string $needle, int $offset = 0, bool $caseSensitive = true)
    {
        if ($caseSensitive) {
            return mb_strpos($haystack, $needle, $offset, static::ENCODING);
        }

        return mb_stripos($haystack, $needle, $offset, static::ENCODING);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function stringPosReverse(
        string $haystack,
        string $needle,
        int $offset = 0,
        bool $caseSensitive = true
    ) {
        if ($caseSensitive) {
            return mb_strrpos($haystack, $needle, $offset, static::ENCODING);
        }

        return mb_strripos($haystack, $needle, $offset, static::ENCODING);
    }
}
