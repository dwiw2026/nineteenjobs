<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('info', 'Belum ada perusahaan terdaftar. Daftarkan sekarang.');
        }

        return view('employer.company.show', compact('company'));
    }

    public function create()
    {
        return view('employer.company.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'website'     => 'nullable|url|max:255',
            'industry'    => 'nullable|string|max:255',
            'size'        => 'nullable|string|in:startup,small,medium,large,enterprise',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'tagline'     => 'nullable|string|max:255',
            'logo'        => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $ext = $request->file('logo')->extension();
            $logoPath = 'companies/logos/' . Str::uuid() . '.' . $ext;
            Storage::disk('public')->put($logoPath, file_get_contents($request->file('logo')));
        }

        $company = Company::create([
            'user_id'     => auth()->id(),
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . Str::random(4),
            'website'     => $validated['website'] ?? null,
            'industry'    => $validated['industry'] ?? null,
            'size'        => $validated['size'] ?? null,
            'location'    => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'tagline'     => $validated['tagline'] ?? null,
            'logo'        => $logoPath,
        ]);

        return redirect()->route('employer.company.edit', $company)
            ->with('success', 'Perusahaan berhasil didaftarkan!');
    }

    // edit() now accepts Company model (matching route /company/{company}/edit)
    public function edit(Company $company)
    {
        // If no param somehow, fallback to auth user's company
        $company ??= auth()->user()->company;

        if (!$company || $company->user_id !== auth()->id()) {
            return redirect()->route('employer.company.create')
                ->with('error', 'Perusahaan tidak ditemukan. Daftarkan terlebih dahulu.');
        }

        return view('employer.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'website'     => 'nullable|url|max:255',
            'industry'    => 'nullable|string|max:255',
            'size'        => 'nullable|string|in:startup,small,medium,large,enterprise',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'tagline'     => 'nullable|string|max:255',
            'logo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $ext = $request->file('logo')->extension();
            $validated['logo'] = 'companies/logos/' . Str::uuid() . '.' . $ext;
            Storage::disk('public')->put($validated['logo'], file_get_contents($request->file('logo')));
        }

        $company->update($validated);

        return redirect()->route('employer.company.edit', $company)
            ->with('success', 'Perusahaan berhasil diperbarui!');
    }

    public function destroy(Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
