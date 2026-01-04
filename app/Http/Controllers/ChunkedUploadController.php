<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class ChunkedUploadController extends Controller
{
  /**
   * Allowed file extensions by folder type
   */
  protected $allowedExtensions = [
    'lessons/videos' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'],
    'uploads' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', 'jpg', 'jpeg', 'png', 'gif', 'pdf'],
  ];

  /**
   * Allowed MIME types by folder type
   */
  protected $allowedMimes = [
    'lessons/videos' => [
      'video/mp4',
      'video/avi',
      'video/quicktime',
      'video/x-ms-wmv',
      'video/x-flv',
      'video/webm',
      'video/x-matroska',
    ],
    'uploads' => [
      'video/mp4',
      'video/avi',
      'video/quicktime',
      'video/x-ms-wmv',
      'video/x-flv',
      'video/webm',
      'video/x-matroska',
      'image/jpeg',
      'image/png',
      'image/gif',
      'application/pdf',
    ],
  ];

  /**
   * Handle chunked file upload
   */
  public function upload(Request $request)
  {
    // Validate folder parameter
    $folder = $request->input('folder', 'uploads');
    $allowedFolders = array_keys($this->allowedExtensions);

    if (!in_array($folder, $allowedFolders)) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid upload folder specified.',
      ], 422);
    }

    $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

    if ($receiver->isUploaded() === false) {
      return response()->json([
        'status' => false,
        'message' => 'No file was uploaded.',
      ], 422);
    }

    $save = $receiver->receive();

    if ($save->isFinished()) {
      return $this->saveFile($save->getFile(), $request, $folder);
    }

    $handler = $save->handler();

    return response()->json([
      'done' => $handler->getPercentageDone(),
      'status' => true
    ]);
  }

  /**
   * Save the final uploaded file with validation
   */
  protected function saveFile($file, Request $request, string $folder)
  {
    // Validate file extension
    $extension = strtolower($file->getClientOriginalExtension());
    $allowedExtensions = $this->allowedExtensions[$folder] ?? $this->allowedExtensions['uploads'];

    if (!in_array($extension, $allowedExtensions)) {
      // Delete the temporary file
      @unlink($file->getPathname());

      return response()->json([
        'status' => false,
        'message' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions),
      ], 422);
    }

    // Validate MIME type
    $mimeType = $file->getMimeType();
    $allowedMimes = $this->allowedMimes[$folder] ?? $this->allowedMimes['uploads'];

    if (!in_array($mimeType, $allowedMimes)) {
      @unlink($file->getPathname());

      return response()->json([
        'status' => false,
        'message' => 'Invalid file MIME type.',
      ], 422);
    }

    $fileName = $this->createFilename($file);
    $filePath = $file->storeAs($folder, $fileName, 'public');

    if (!$filePath) {
      return response()->json([
        'status' => false,
        'message' => 'Failed to save file.',
      ], 500);
    }

    return response()->json([
      'done' => 100,
      'status' => true,
      'path' => $filePath,
      'filename' => $fileName,
      'url' => Storage::disk('public')->url($filePath)
    ]);
  }

  /**
   * Create unique filename
   */
  protected function createFilename($file)
  {
    $extension = $file->getClientOriginalExtension();
    $filename = str_replace('.' . $extension, '', $file->getClientOriginalName());
    $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '_', $filename);

    return $filename . '_' . time() . '.' . $extension;
  }
}
