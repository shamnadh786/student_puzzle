<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\GameSession;
use App\Models\Submission;
use App\Models\LeaderShip;
use App\Traits\GeneratesPuzzle;
use App\Services\WordPuzzleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    use GeneratesPuzzle; // Using Trait for generating the puzzle word
    protected WordPuzzleService $puzzleService;

    public function __construct(WordPuzzleService $gameService)
    {
        $this->puzzleService = $gameService;
    }

    public function index(Request $request)
    {
        try {
             
            $student = Auth::user();
            if (!$student) {
                $request->validate([
                'studentEmail' => 'required|email|max:255',
                'studentName' => 'required|string|min:2|max:100',
                ]);
                $student = Student::firstOrCreate(
                    ['email' => $request->input('studentEmail')],
                    ['name' => $request->input('studentName')]
                );
                Auth::guard('student')->login($student);
            }
            $puzzle = $this->generatePuzzleString();
            $session = GameSession::create([
                'student_id' => $student->id,
                'puzzle_string' => $puzzle,
                'remaining_letters' => $puzzle,
            ]);
            session::put('game_session_id', $session->id);
            return view('game.puzzlePage', compact('session'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function storeWord(Request $request)
    {
        $gameSessionId = session::has('game_session_id') ? session('game_session_id') : null;
        $puzzleWord = $request->puzzleWord;
        if ($gameSessionId) {
            $validated = $request->validate([
                'puzzleWord' => 'required|string',
            ]);
        }
        $gameSession = GameSession::findOrFail($gameSessionId);
        try {
            $result = $this->puzzleService->submitWord($gameSession, $puzzleWord);
            $submission = Submission::where('game_session_id', $gameSession->id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Word accepted.',
                'score' => $result['score'],
                'puzzleString' => $result['remaining_letters'],
                'submission' => $submission,
                'is_game_over'=> $result['is_game_over']
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function finishGame()
    {
        $gameSessionId = session::has('game_session_id') ? session('game_session_id') : null;
        $session = GameSession::findOrFail($gameSessionId);
        $session->is_active = false;
        $session->save();
        $totalScore = $session->submissions->sum('score');
        return view('game.finishGamePage', compact('totalScore'));
    }

    public function leaderBoard()
    {
        $leaderScore = LeaderShip::with('student')->orderByDesc('score')->limit(10)->get();
        return view('leadership.leaderBoard', compact('leaderScore'));
    }
    public function signout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
