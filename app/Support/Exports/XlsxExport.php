<?php

namespace App\Support\Exports;

use Shuchkin\SimpleXLSXGen;

class XlsxExport
{
    /**
     * Creates a simple XLSX (no external PHP extensions needed).
     *
     * @param  array<int, string> $headers
     * @param  array<int, array<int, mixed>> $rows
     */
    public static function download(string $filename, array $headers, array $rows)
    {
        $sheet = [];
        $sheet[] = $headers;
        foreach ($rows as $r) {
            $sheet[] = array_map(fn ($v) => is_scalar($v) || $v === null ? $v : json_encode($v), $r);
        }

        // Use raw download content (no direct output/exit).
        $xlsx = SimpleXLSXGen::fromArray($sheet, 'Report');
        $xlsxData = $xlsx->download(); // returns string (xlsx binary)

        return response($xlsxData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }
}

