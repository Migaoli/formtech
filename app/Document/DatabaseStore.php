<?php


namespace App\Document;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseStore implements DocumentStore
{

    public function find($id, $type = null): Document
    {
        $query = DB::table('documents');

        if ($this !== null) {
            $query->where('type', $type);
        }

        $data = $query->find($id);

        return $this->createDocumentFromDatabase($data);
    }

    public function findOrFail($id, $type = null): Document
    {
        $doc = $this->find($id, $type);

        if ($doc === null) {
            throw new DocumentNotFoundException("Could not find document with id: $id.");
        }

        return $doc;
    }

    public function all($type = null): Collection
    {
        $query = DB::table('documents');

        if ($this !== null) {
            $query->where('type', $type);
        }

        return $query->get()
            ->map(function ($data) {
                return $this->createDocumentFromDatabase($data);
            });
    }

    public function save(Document $document)
    {
        $document->validate();

        $success = DB::table('documents')->updateOrInsert(
            ['id' => $document->id()],
            [
                'type' => $document->documentType(),
                'implementation' => $document->implementationClass(),
                'attributes' => $document->attributes(),
            ]);

        if (!$success) {
            throw new \RuntimeException("could not save document");
        }
    }

    public function delete(Document $document)
    {
        DB::table('document')->delete($document->id());
    }

    private function createDocumentFromDatabase($data): Document
    {
        $doc = new $data->implementation();

        $doc->fromStorage($data->id, json_decode($doc->attributes, true));

        return $doc;
    }


}