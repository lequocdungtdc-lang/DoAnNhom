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

        ten_bai_hat | nghe_si | the_loai | album | file_am_thanh | anh_dai_dien | luot_nghe | status
        */

        // tìm nghệ sĩ
        $artist = Artist::where('name_artist', $row['nghe_si'] ?? 0)->first();

        // tìm thể loại
        $category = Categories::where('tentheloai', $row['the_loai'] ?? 0)->first();

        // tìm album
        $album = Album::where('ten_album', $row['album'] ?? 0)->first();

        $arrSong = [
            'nghesi'       => $artist?->id ?? 0,
            'theloai'      => $category?->id ?? 0,
            'id_album'     => $album?->id ?? 0,
            'file_amthanh' => $row['file_am_thanh'] ?? '',
            'anh_daidien'  => $row['anh_dai_dien'] ?? '',
            'luot_nghe'    => $row['luot_nghe'] ?? 0,
            'status'       => $row['status'] ?? 1,
        ];

        return Song::updateOrCreate(
            [
                // điều kiện kiểm tra tồn tại
                'tenbaihat' => $row['ten_bai_hat'] ?? '',
            ],
            $arrSong
        );
    }
}