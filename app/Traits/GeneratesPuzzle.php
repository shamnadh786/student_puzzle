<?php
namespace App\Traits;

trait GeneratesPuzzle
{
   public function generatePuzzleString(int $length = 14){
     $dictionary = file(storage_path('app/wordslist.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     $validWords = array_filter($dictionary, fn($word) => strlen($word) >= 3 && ctype_alpha($word));
     $baseWord = strtolower($validWords[array_rand($validWords)] ?? 'word');
     $extra = '';
        $needed = max(0, $length - strlen($baseWord));
        for ($i = 0; $i < $needed; $i++) {
            // random a-z
            $extra .= chr(rand(97, 122)); 
        }

        return str_shuffle($baseWord . $extra);
   }
}
