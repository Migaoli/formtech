<?php


namespace App\Document;


use Illuminate\Support\Collection;

interface DocumentStore
{
    public function find($id, $type = null): Document;

    public function findOrFail($id, $type = null): Document;

    public function all($type = null): Collection;

    public function save(Document $document);

    public function delete(Document $document);
}