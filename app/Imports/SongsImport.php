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

        // tìm nghệ sĩ
        $artist = Artist::where('name', $row['artist'] ?? '')->first();

        // tìm thể loại
        $category = Categories::where('name', $row['category'] ?? '')->first();

        // tìm album
        $album = Album::where('title', $row['album'] ?? '')->first();

        $arrSong = [
            'artist_id'    => $artist?->id,
            'category_id'  => $category?->id,
            'album_id'     => $album?->id,
            'audio_file'   => $row['audio_file'] ?? '',
            'thumbnail'    => $row['thumbnail'] ?? '',
            'listen_count' => $row['listen_count'] ?? 0,
            'status'       => $row['status'] ?? 1,
        ];

        return Song::updateOrCreate(
            [
                // điều kiện kiểm tra tồn tại
                'title' => $row['title'] ?? '',
            ],
            $arrSong
        );
    }
}