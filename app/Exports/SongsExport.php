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
                'album',
            ])
            ->get()
            ->map(function ($song) {

                return [
                    $song->title,
                    $song->artist?->name ?? '',
                    $song->category?->name ?? '',
                    $song->album?->title ?? '',
                    $song->audio_file,
                    $song->thumbnail,
                    $song->listen_count,
                    $song->view_count,
                    $song->status ? 1 : 0,
                    optional($song->created_at)->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'title',
            'artist',
            'category',
            'album',
            'audio_file',
            'thumbnail',
            'listen_count',
            'views',
            'status',
            'created_at',
        ];
    }
}