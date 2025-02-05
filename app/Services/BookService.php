<?php

namespace App\Services;

use App\Models\Book;
use App\Http\Resources\BookResource;

class BookService
{
    public function getAllBooks()
    {
        return BookResource::collection(Book::all());
    }

    public function getBookById($id)
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

    public function createBook(array $data)
    {
        $book = Book::create($data);
        return new BookResource($book);
    }

    public function updateBook($id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return new BookResource($book);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
