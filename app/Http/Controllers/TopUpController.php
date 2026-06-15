<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    // ================= CUSTOMER METHODS ================= //

    public function index()
    {
        $topUps = Auth::user()->topUps()->latest()->get();
        return view('topups.index', compact('topUps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000',
        ]);

        // Strip dots if any (e.g. 1.000.000 -> 1000000)
        $amount = (int) str_replace('.', '', $request->amount);

        Auth::user()->topUps()->create([
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return redirect()->route('topups.index')->with('success', 'Top-up request submitted successfully! Please wait for admin approval.');
    }

    // ================= ADMIN METHODS ================= //

    public function adminIndex()
    {
        // Get all top-ups, maybe paginate or get latest
        $topUps = TopUp::with('user')->latest()->get();
        return view('admin.topups.index', compact('topUps'));
    }

    public function approve(TopUp $topup)
    {
        if ($topup->status !== 'pending') {
            return back()->with('error', 'Top-up is already processed.');
        }

        $topup->update(['status' => 'approved']);
        
        // Add money to user
        $topup->user->increment('money', $topup->amount);

        return back()->with('success', 'Top-up approved successfully!');
    }

    public function reject(TopUp $topup)
    {
        if ($topup->status !== 'pending') {
            return back()->with('error', 'Top-up is already processed.');
        }

        $topup->update(['status' => 'rejected']);

        return back()->with('success', 'Top-up rejected.');
    }
}
