<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {

        $feedback = Feedback::latest()->paginate(10);
        return view('feedback.index', compact('feedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'message' => 'required|max:100',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'name' => Auth::check() ? Auth::user()->name : $request->name,
            'email' => Auth::check() ? Auth::user()->email : $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Terima kasih atas feedback Anda!');
    }

    public function updateStatus(Feedback $feedback)
    {
        $feedback->update(['status' => 'dibaca']);
        return back()->with('success', 'Status feedback diperbarui.');
    }
}
