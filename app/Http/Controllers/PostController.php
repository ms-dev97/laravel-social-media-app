<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(StorePostRequest $request) {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $filePaths = [];
        
        DB::beginTransaction();
        try {
            $post = Post::create($data);

            foreach($data['files'] as $file) {
                $path = $file->store('attachments', 'public');
                $filePaths[] = $path;

                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $data['user_id']
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            foreach($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }

            DB::rollBack();
            throw $e;
        }

        return back();
    }

    public function update(UpdatePostRequest $request, Post $post) {
        $data = $request->validated();
        $post->update($data);

        return back();
    }
}
