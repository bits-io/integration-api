<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        return $this->bookService->getAllBooks();
    }

    public function show($id)
    {
        return $this->bookService->getBookById($id);
    }

    public function store(BookRequest $request)
    {
        return $this->bookService->createBook($request->validated());
    }

    public function update(BookRequest $request, $id)
    {
        return $this->bookService->updateBook($id, $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->bookService->deleteBook($id);
    }
}
