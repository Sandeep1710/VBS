<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:120'],
            'name' => ['nullable', 'string', 'max:120'],
        ]);

        $sub = NewsletterSubscriber::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? null,
                'is_active' => true,
                'source' => 'web',
            ],
        );

        // Re-activate if previously unsubscribed
        if (! $sub->is_active) {
            $sub->forceFill([
                'is_active' => true,
                'unsubscribed_at' => null,
            ])->save();
        }

        return back()->with('success', 'Thanks! You are subscribed.');
    }

    public function unsubscribe(string $token): View
    {
        $sub = NewsletterSubscriber::where('unsubscribe_token', $token)->firstOrFail();

        $sub->forceFill([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ])->save();

        return view('newsletter.unsubscribed', ['email' => $sub->email]);
    }
}
