<?php

namespace Database\Seeders;

use App\Models\LegalDocument;
use Illuminate\Database\Seeder;

class LegalDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = LegalDocument::getDefaultsArray();

        foreach ($defaults as $slug => $data) {
            LegalDocument::updateOrCreate(
                ['slug' => $slug],
                $data
            );
        }
    }
}
