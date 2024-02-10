<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file');
        $events_id = $request->input('events_id');

        $created_at = now();
        $created_by = Auth::user()->name;
        $user_id = Auth::user()->id;

        $path = 'attachments/' . $events_id;
        $fileName = $file->getClientOriginalName();
        $file->storeAs("public/{$path}", $fileName);

        $attachment = new Attachment([
            'file' => $fileName,
            'path' => $path,
            'created_at' => $created_at,
            'created_by' => $created_by,
            'user_id' => $user_id,
            'events_id' => $events_id,
        ]);

        $attachment->save();

        return response()->json(['message' => 'File Uploaded Successfully'], 200);
    }

    public function destroy(Attachment $attachment)
    {
        $filePath = storage_path("app/public/{$attachment->path}/{$attachment->file}");
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $attachment->delete();

        return response()->json(['message' => 'Attachment Deleted Successfully'], 200);
    }
}
