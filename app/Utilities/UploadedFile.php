<?php

namespace App\Utilities;

use Exception;

class UploadedFile extends \Illuminate\Http\UploadedFile
{

    /**
     * @param string $url
     * @param string $originalName
     * @param string|null $mimeType
     * @param int|null $error
     * @param bool $test
     * @return static
     * @throws Exception
     */
    public static function createFromUrl(string $url, string $originalName = '', string $mimeType = null, int $error = null, bool $test = false): self
    {
        $tempFile = download_from_url($url, 'url-file-');

        return new static($tempFile, $originalName, $mimeType, $error, $test);
    }
}
