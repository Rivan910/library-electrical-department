<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'sheet_row_number',
        'no',
        'document_no',
        'vendor',
        'title',
        'content',
        'rack',
        'notes',
    ];

    /**
     * Generate 2-letter vendor badge code (e.g., "FL" from "F.L.SMIDTH & CO. A/S DENMARK").
     */
    public function getVendorCodeAttribute(): string
    {
        $vendor = trim((string) $this->vendor);
        if ($vendor === '') {
            return '--';
        }

        $clean = preg_replace('/[^A-Za-z0-9\s]/', '', $vendor);
        $words = array_values(array_filter(explode(' ', trim((string) $clean))));

        if (count($words) >= 2 && strlen($words[0]) === 1 && strlen($words[1]) === 1) {
            return strtoupper($words[0] . $words[1]);
        }

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($words[0] ?? $vendor, 0, 2));
    }

    /**
     * Determine display content type (uses Content column if filled, or infers from Title).
     */
    public function getDisplayContentAttribute(): string
    {
        $content = trim((string) $this->content);
        if ($content !== '') {
            return $content;
        }

        $titleUpper = strtoupper((string) $this->title);
        if (str_contains($titleUpper, 'DRAWING')) {
            return 'Drawing';
        }
        if (str_contains($titleUpper, 'MANUAL') || str_contains($titleUpper, 'INSTRUCTION')) {
            return 'Manual';
        }
        if (str_contains($titleUpper, 'PART') || str_contains($titleUpper, 'LIST')) {
            return 'Parts List';
        }
        if (str_contains($titleUpper, 'DATASHEET') || str_contains($titleUpper, 'DATA SHEET')) {
            return 'Datasheet';
        }
        if (str_contains($titleUpper, 'ELECTRICAL')) {
            return 'Electrical Doc';
        }

        return '-';
    }
}
