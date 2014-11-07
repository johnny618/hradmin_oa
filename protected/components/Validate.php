<?php
class Validate {

    /**
     * Checks whether a string consists of digits only (no dots or dashes).
     *
     * @param   string   input string
     * @param   boolean  trigger UTF-8 compatibility
     * @return  boolean
     */
    public static function digit($str, $utf8 = FALSE) {
        if ($utf8 === TRUE) {
            return (bool)preg_match('/^\pN++$/uD', $str);
        } else {
            return (is_int($str) and $str >= 0) or ctype_digit($str);
        }
    }

    public static function email($email, $strict = FALSE) {
        if ($strict === TRUE) {
            $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
            $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
            $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
            $pair = '\\x5c[\\x00-\\x7f]';

            $domain_literal = "\\x5b($dtext|$pair)*\\x5d";
            $quoted_string = "\\x22($qtext|$pair)*\\x22";
            $sub_domain = "($atom|$domain_literal)";
            $word = "($atom|$quoted_string)";
            $domain = "$sub_domain(\\x2e$sub_domain)*";
            $local_part = "$word(\\x2e$word)*";

            $expression = "/^$local_part\\x40$domain$/D";
        } else {
            $expression = '/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD';
        }

        return (bool)preg_match($expression, (string)$email);
    }

    public static function compare($number1, $number2, $_operator) {
        $return = false;
        switch ($_operator) {
            case '>':
                $return = $number1 > $number2;
                break;
            case '>=':
                $return = $number1 >= $number2;
                break;
            case '=':
                $return = $number1 == $number2;
                break;
            case '<':
                $return = $number1 < $number2;
                break;
            case '<=':
                $return = $number1 <= $number2;
                break;
            default:
                $return = false;
                break;
        }
        return $return;
    }

}