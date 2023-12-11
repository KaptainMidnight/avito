<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class StorageService
{
    /**
     * Оригинальное название файла
     */
    protected string $originalName;

    /**
     * Новое название файла для сохранения у нас
     */
    protected string $filename;

    /**
     * Расширение файла
     */
    protected string $extension;

    /**
     * Имя файла для сохранения
     */
    protected string $storeName;

    /**
     * Размер файла
     */
    protected int $size;

    /**
     * Путь до файла
     */
    protected string $path;

    public function storeFile(UploadedFile $file, Model $model): Model
    {
        $this->extractFileData($file);

        $attachment = new Attachment([
            'name' => $this->filename,
            'original_name' => $this->originalName,
            'path' => str($this->path)->replace('public', 'storage'),
            'size' => $this->size,
        ]);
        $attachment->attachmentable()->associate($model)->save();

        return $attachment;
    }

    /**
     * Вытащить нужные данные из файла
     */
    private function extractFileData(UploadedFile $file): void
    {
        $this->originalName = $file->getClientOriginalName();
        $this->filename = md5(pathinfo($this->originalName, PATHINFO_FILENAME));
        $this->extension = $file->extension();
        $this->storeName = "{$this->filename}_".time().".{$this->extension}";
        $this->size = $file->getSize();
        $this->path = $file->storeAs(path: 'public', name: $this->storeName);
    }
}
