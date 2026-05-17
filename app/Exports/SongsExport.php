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
                    $song->title,
                    $song->artist?->name ?? '',
                    $song->category?->name ?? '',
                    $song->album?->title ?? '',
                    $song->audio_file,
                    $song->thumbnail,
                    $song->listen_count,
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