@php
    /** @var \App\Models\Application $record */
    $files = ($record->files ?? collect())->values();

    $rows = $files->map(function ($file) use ($record) {
        $uploader = $file->uploaded_by === 'admin'
            ? 'Admin'
            : ($record->user->name ?? 'Pemohon');

        return [
            'name' => $file->type?->label() ?? (string) $file->type,
            'uploader' => $uploader,
            'date' => optional($file->created_at)->format('d/m/Y') ?? '-',
            'url' => $file->url ?? null,
        ];
    });
@endphp

<div class="px-6 py-4">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-gray-600">
            Daftar dokumen yang diupload pemohon / admin.
        </div>

        <div class="flex flex-wrap items-center gap-2">

            {{ $this->getAction('uploadSuratJawaban') }}
            {{ $this->getAction('uploadSuratSelesai') }}
        </div>
    </div>

    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600">
                        <th class="px-4 py-3 font-medium">Nama Dokumen</th>
                        <th class="px-4 py-3 font-medium">Diupload Oleh</th>
                        <th class="px-4 py-3 font-medium">Tanggal Upload</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3 text-gray-900">
                                {{ $row['name'] }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $row['uploader'] }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                                {{ $row['date'] }}
                            </td>

                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if($row['url'])
                                    <a
                                        href="{{ $row['url'] }}"
                                        target="_blank"
                                        class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-gray-700 hover:bg-gray-50"
                                    >
                                        Unduh
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                Belum ada dokumen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
