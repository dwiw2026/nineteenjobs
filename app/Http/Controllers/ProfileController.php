<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateCandidate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'headline' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $skills = $validated['skills'] ? array_map('trim', explode(',', $validated['skills'])) : [];

        $profile = $request->user()->candidateProfile;
        if ($profile) {
            $data = [
                'headline' => $validated['headline'],
                'skills' => $skills,
                'experience_years' => $validated['experience_years'],
                'location' => $validated['location'],
            ];

            if ($request->hasFile('resume')) {
                if ($profile->resume_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->resume_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->resume_path);
                }
                $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
            }

            $profile->update($data);
            $profile->recalculateCompleteness();
        }

        return Redirect::route('profile.edit')->with('success', 'Profil kandidat berhasil diperbarui.');
    }
}
