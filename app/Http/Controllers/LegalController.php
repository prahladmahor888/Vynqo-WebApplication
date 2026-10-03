<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Community Guidelines Page (retrieved from database)
     */
    public function guidelines()
    {
        $document = LegalDocument::getBySlug('guidelines');
        return view('pages.guidelines', compact('document'));
    }

    /**
     * Privacy Policy Page (retrieved dynamically from database)
     */
    public function privacy()
    {
        $document = LegalDocument::getBySlug('privacy');
        
        // Fetch dynamic active permissions with structured fallback
        try {
            $permissions = \App\Models\AppPermission::active()->get();
            if ($permissions->isEmpty()) {
                $permissions = collect(\App\Models\AppPermission::getDefaultPermissions());
            }
        } catch (\Throwable $e) {
            $permissions = collect(\App\Models\AppPermission::getDefaultPermissions());
        }

        return view('pages.privacy', compact('document', 'permissions'));
    }

    /**
     * Terms of Service Page (retrieved from database)
     */
    public function terms()
    {
        $document = LegalDocument::getBySlug('terms');
        return view('pages.terms', compact('document'));
    }

    /**
     * Security & E2EE Whitepaper Page (retrieved from database)
     */
    public function security()
    {
        $document = LegalDocument::getBySlug('security');
        return view('pages.security', compact('document'));
    }
}

