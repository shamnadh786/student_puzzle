<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\Submission;
use App\Models\GameSession;
use App\Models\LeaderShip;
use Illuminate\Support\Facades\Validator;

class SubmissionAndLeaderboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_valid_game_session()
    {
        $studentData = [
            'studentName' => 'Alice',
            'studentEmail' => 'alice@example.com',
        ];
        $response = $this->post('/start-game', $studentData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('students', ['email' => 'alice@example.com']);
        $student = Student::where('email', 'alice@example.com')->first();
        $this->assertDatabaseHas('game_sessions', ['student_id' => $student->id]);
        $response->assertViewIs('game.puzzlePage');
    }

    public function test_it_submits_word_and_returns_json_response()
    {
        $student = Student::factory()->create();
        $puzzle = 'bedacfghijklm';

        $gameSession = GameSession::create([
            'student_id' => $student->id,
            'puzzle_string' => $puzzle,
            'remaining_letters' => $puzzle,
            'is_active' => true,
        ]);

        $this->actingAs($student, 'student');
        // Store game session  ID
        $this->withSession(['game_session_id' => $gameSession->id]);

        // Post a valid word from the puzzle string
        $response = $this->postJson('/storeWord', [
            'puzzleWord' => 'bed',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'Word accepted.',
            'score' => 3,
            'is_game_over' => false,
        ]);
        $this->assertDatabaseHas('submissions', [
            'game_session_id' => $gameSession->id,
            'word' => 'bed',
            'score' => 3,
        ]);
    }

    public function test_it_adds_to_leaderboard()
    {
        $student = Student::factory()->create();
        $puzzle = 'bananaxyz';

        $gameSession = GameSession::create([
            'student_id' => $student->id,
            'puzzle_string' => $puzzle,
            'remaining_letters' => $puzzle,
            'is_active' => true,
        ]);

        $this->actingAs($student, 'student');
        $this->withSession(['game_session_id' => $gameSession->id]);

        LeaderShip::truncate();

        // Submit a word that should be added to leaderboard
        $response = $this->postJson('/storeWord', [
            'puzzleWord' => 'banana',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'Word accepted.',
        ]);

        $this->assertDatabaseHas('leader_ships', [
            'student_id' => $student->id,
            'word' => 'banana',
            'score' => 6,
        ]);
    }

    /** @test */
    public function test_word_not_add_to_leaderboard_if_word_already_exists()
    {
        $student = Student::factory()->create();
        $puzzle = 'bananaxyz';
        $gameSession = GameSession::create([
            'student_id' => $student->id,
            'puzzle_string' => $puzzle,
            'remaining_letters' => $puzzle,
            'is_active' => true,
        ]);
        $this->actingAs($student, 'student');
        $this->withSession(['game_session_id' => $gameSession->id]);
        LeaderShip::truncate();
        $response = $this->postJson('/storeWord', [
            'puzzleWord' => 'banana',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(1, LeaderShip::where('word', 'banana')->count());
    }

    public function test_it_limits_leaderboard_to_top_10_scores()
    {
        LeaderShip::truncate();

        // Create 10 entries in LeaderShip
        for ($i = 0; $i < 10; $i++) {
            LeaderShip::create([
                'student_id' => Student::factory()->create()->id,
                'word' => 'word' . $i,
                'score' => $i + 1, 
            ]);
        }

        $student = Student::factory()->create();
        $puzzle = 'elephantxyz';

        $gameSession = GameSession::create([
            'student_id' => $student->id,
            'puzzle_string' => $puzzle,
            'remaining_letters' => $puzzle,
            'is_active' => true,
        ]);

        $this->actingAs($student, 'student');
        $this->withSession(['game_session_id' => $gameSession->id]);

        $response = $this->postJson('/storeWord', [
            'puzzleWord' => 'elephant',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(10,LeaderShip::count());
        $this->assertDatabaseHas('leader_ships', [
            'word' => 'elephant',
            'student_id' => $student->id,
        ]);
    }
}
