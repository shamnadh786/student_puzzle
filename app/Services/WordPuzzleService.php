<?php

namespace App\Services;
use App\Models\GameSession;
use App\Models\Submission;
use App\Models\LeaderShip;
use App\Traits\WordValidationTrait;
class WordPuzzleService
{
   use WordValidationTrait;

   public function submitWord($session, string $word){
   
      $gameOver = false;
      //First check the session is active or not
      if (!$session->is_active) {
            throw new \Exception('Session has ended');
      }
      $word = strtolower($word);
      $remaining = $session->remaining_letters;

      // Check the word is a valid english or not
      if(!($this->isValid($word))){
          throw new \Exception('Invalid English word.');
      }
      // Check that we can create a valid word from remainingLetters
      if (!($this->possibleToFormWord($word, $remaining))) {
            throw new \Exception('Letters not available.');
      }

      // Find used words and deduct the letters from remaining
      $wordsUsed = $this->removeWords($word, $remaining);
      $session->remaining_letters = $wordsUsed;
      $session->save();
      if(!$this->checkPossibleValidWord($wordsUsed)){
        $session->is_active = false;
        $session->save();
        $gameOver = true;
      }
      // Finding the score
      $score = $this->getScoreFromWord($word);
      // Creating a submission against game session
      Submission::create([
            'game_session_id' => $session->id,
            'word' => $word,
            'score' => $score,
        ]);

        if (!LeaderShip::where('word', $word)->exists()) {
            $lowScore = LeaderShip::orderBy('score')->first();
            if (LeaderShip::count() < 10 || $lowScore->score < $score) {
                if (LeaderShip::count() >= 10) $lowScore?->delete();
                LeaderShip::create([
                    'word' => $word,
                    'score' => $score,
                    'student_id' => $session->student_id,
                ]);
            }
        }
        return [
            'score' => $score,
            'remaining_letters' => $wordsUsed,
            'is_game_over' =>$gameOver
        ];


   }
}