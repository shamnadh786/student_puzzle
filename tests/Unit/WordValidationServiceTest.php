<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\GeneratesPuzzle;
use App\Traits\WordValidationTrait;
class WordValidationServiceTest extends TestCase
{
       
    use GeneratesPuzzle,WordValidationTrait;

    public function test_it_accepts_valid_english_word()
    {
        $this->assertTrue($this->isValid('apple'));
    }

    public function test_it_rejects_non_dictionary_word()
    {
        $this->assertFalse($this->isValid('xqzttt'));
    }

    public function test_puzzle_string_is_correct_length_and_format()
    {
        $puzzle = $this->generatePuzzleString();
        $this->assertEquals(14, strlen($puzzle));
        $this->assertMatchesRegularExpression('/^[a-z]+$/', $puzzle);
    }

    public function test_it_can_form_word_from_given_letters()
    {
        $this->assertTrue($this->possibleToFormWord('bed', 'abdecfg'));
    }

    public function test_it_cannot_form_word_if_letters_missing()
    {
        $this->assertFalse($this->possibleToFormWord('buzz', 'abcdefg'));
    }

    public function test_it_deducts_letters_correctly()
    {
    
        $remaining = $this->removeWords('bed', 'abdecfg');
        $this->assertStringNotContainsString('b', $remaining);
        $this->assertStringNotContainsString('e', $remaining);
        $this->assertStringNotContainsString('d', $remaining);
    }

    public function test_it_does_not_fail_when_word_has_duplicate_letters()
    {
        $this->assertTrue($this->possibleToFormWord('book', 'obkoatlgwe'));
        $this->assertFalse($this->possibleToFormWord('book', 'obkatlgwe')); // missing one 'o'
    }
    public function test_it_cannot_make_valid_word_from_remaining(){
         $this->assertFalse($this->checkPossibleValidWord('lhz'));
    }
}
