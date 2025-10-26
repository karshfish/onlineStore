<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            //  Validate input
            $validated = $request->validate([
                'commentable_type' => 'required|string',
                'commentable_id'   => 'required|integer',
                'content'          => 'required|string|max:2000',
                'author_name'      => 'required|string|max:255',
                'author_email'     => 'required|email|max:255',
            ]);

            //  Resolve model dynamically
            $modelClass = $validated['commentable_type'];
            if (!class_exists($modelClass)) {
                return back()->withErrors(['Invalid model type'])->withInput();
            }

            $model = $modelClass::find($validated['commentable_id']);
            if (!$model) {
                return back()->withErrors(['The item you are commenting on was not found'])->withInput();
            }

            //  Create the comment the commentable type and id will be filled automatically this safer
            $model->comments()->create([
                'content' => $validated['content'],
                'author_name' => $validated['author_name'],
                'author_email' => $validated['author_email'],
            ]);

            return back()->with('success', 'Comment added successfully!');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return back()->with('success', 'Comment deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Comment not found.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
