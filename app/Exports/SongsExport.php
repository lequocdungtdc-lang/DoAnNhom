<?php

namespace App\Exports;

use App\Models\Song;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SongsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Song::with([
                'artist',
                'category',
                'album'
            ])
            ->get()
            ->map(function ($song) {

                return [
                    $song->id,
                    $song->tenbaihat,
                    $song->artist?->ten_nghesi ?? '',
                    $song->category?->ten_theloai ?? '',
                    $song->album?->ten_album ?? '',
                    $song->file_amthanh,
                    $song->anh_daidien,
                    $song->luot_nghe,
                    $song->view_count,
                    $song->status ? 'Hiển thị' : 'Ẩn',
                    optional($song->created_at)->format('d/m/Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên bài hát',
            'Nghệ sĩ',
            'Thể loại',
            'Album',
            'File âm thanh',
            'Ảnh đại diện',
            'Lượt nghe',
            'Lượt xem',
            'Trạng thái',
            'Ngày tạo',
        ];
    }
}