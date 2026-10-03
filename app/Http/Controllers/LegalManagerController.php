<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;

class LegalManagerController extends Controller
{
    /**
     * Admin index: List all legal documents managed in database.
     */
    public function index()
    {
        $slugs = ['privacy', 'guidelines', 'terms', 'security'];
        $documents = [];

        foreach ($slugs as $slug) {
            $documents[$slug] = LegalDocument::getBySlug($slug);
        }

        return view('pages.admin-legal', compact('documents'));
    }

    /**
     * Edit form for a specific legal document (e.g. privacy, guidelines).
     */
    public function edit(string $slug)
    {
        $allowed = ['privacy', 'guidelines', 'terms', 'security'];
        if (!in_array($slug, $allowed)) {
            return redirect()->route('admin.legal.index')->with('error', 'Invalid legal document.');
        }

        $document = LegalDocument::getBySlug($slug);
        return view('pages.admin-legal-edit', compact('document', 'slug'));
    }

    /**
     * Save/Update legal document in database.
     */
    public function update(Request $request, string $slug)
    {
        $allowed = ['privacy', 'guidelines', 'terms', 'security'];
        if (!in_array($slug, $allowed)) {
            return redirect()->route('admin.legal.index')->with('error', 'Invalid legal document.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'version' => 'required|string|max:50',
            'effective_date' => 'required|string|max:100',
            'summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
        ]);

        LegalDocument::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $validated['title'],
                'subtitle' => $validated['subtitle'],
                'version' => $validated['version'],
                'effective_date' => $validated['effective_date'],
                'summary' => $validated['summary'],
                'content' => $validated['content'],
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.legal.index')->with('success', "Legal document '{$validated['title']}' updated successfully in database!");
    }

    /**
     * Reset legal document back to official default content.
     */
    public function reset(string $slug)
    {
        $defaults = LegalDocument::getDefaultsArray();
        if (isset($defaults[$slug])) {
            LegalDocument::updateOrCreate(
                ['slug' => $slug],
                $defaults[$slug]
            );
            return redirect()->route('admin.legal.index')->with('success', "Reset '{$slug}' policy back to official default.");
        }

        return redirect()->route('admin.legal.index')->with('error', 'Document not found.');
    }
}
