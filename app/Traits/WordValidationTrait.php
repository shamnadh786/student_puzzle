<?php
namespace App\Traits;

trait WordValidationTrait
{
    public static function getDictionary()
    {
        static $dictionary = null;

        if (is_null($dictionary)) {
            $dictionary = file(storage_path('app/wordslist.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        return $dictionary;
    }
    // Checks whether the word is a valid english word.
    public static function isValid($word)
    {
        $dictionary = file(storage_path('app/wordslist.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return in_array($word, array_map('strtolower', $dictionary));
    }
    // Removes the used word from remaining
    public static function removeWords($word, $remainingLetters)
    {
        foreach (str_split($word) as $char) {
            $remainingLetters = preg_replace("/$char/", '', $remainingLetters, 1);
        }
        return $remainingLetters;
    }
    // Checks whether the word is a valid english word
    public static function possibleToFormWord($word, $remainingLetters)
    {
        foreach (count_chars($word, 1) as $char => $count) {
            if (substr_count($remainingLetters, chr($char)) < $count) {
                return false;
            }
        }
        return true;
    }
    // // Checking both we can create a valid english word from remaing letters
    // public static function validWordFromRemaining($word, $remainingLetters)
    // {
    //     return self::isValid($word) && self::possibleToFormWord($word, $remainingLetters);
    // }
    public function checkPossibleValidWord($remainingLetters)
    {
        $dictionary = self::getDictionary();

        foreach ($dictionary as $word) {
            $word = strtolower(trim($word));
            if (strlen($word) < 3) {
                continue;
            }
            // Skipping long words
            if (strlen($word) > strlen($remainingLetters)) {
                continue;
            }
            
            if ($this->possibleToFormWord($word, $remainingLetters)) {
                return true;
            }
            
        }
        // No valid word found
        return false;
    }
    // Find the score with words
    public static function getScoreFromWord($word)
    {
        return strlen($word);
    }
}
