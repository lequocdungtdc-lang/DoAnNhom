<?php

namespace App\Imports;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Categories;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SongsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        /*
        File Excel mẫu:

        title | artist | category | album | audio_file | thumbnail | listen_count | status
        */

        $title = trim((string) ($row['title'] ?? ''));
        $categoryName = trim((string) ($row['category'] ?? ''));
        $audioFile = trim((string) ($row['audio_file'] ?? ''));

        if ($title === '') {
            throw new \InvalidArgumentException('Cột title không được để trống.');
        }

        if ($categoryName === '') {
            throw new \InvalidArgumentException('Cột category không được để trống.');
        }

        if ($audioFile === '') {
            throw new \InvalidArgumentException('Cột audio_file không được để trống.');
        }

        $artistName = trim((string) ($row['artist'] ?? ''));
        $albumTitle = trim((string) ($row['album'] ?? ''));

        $artist = $artistName !== ''
            ? Artist::where('name', $artistName)->first()
            : null;

        $category = Categories::where('name', $categoryName)->first();

        if (! $category) {
            throw new \InvalidArgumentException('Không tìm thấy thể loại: ' . $categoryName);
        }

        $album = $albumTitle !== ''
            ? Album::where('title', $albumTitle)->first()
            : null;

        $arrSong = [
            'artist_id'    => $artist?->id,
            'category_id'  => $category->id,
            'album_id'     => $album?->id,
            'audio_file'   => $audioFile,
            'thumbnail'    => trim((string) ($row['thumbnail'] ?? '')),
            'listen_count' => (int) ($row['listen_count'] ?? 0),
            'status'       => filter_var($row['status'] ?? true, FILTER_VALIDATE_BOOLEAN),
        ];

        return Song::updateOrCreate(
            [
                // điều kiện kiểm tra tồn tại
                'title' => $title,
            ],
            $arrSong
        );
    }
}