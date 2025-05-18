<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class CommentSection extends Component
{
    public $post;
    public $body = '';
    public $comments;

    public function mount()
    {
        $this->loadComments();
    }

    private function loadComments()
    {
        $this->comments = $this->post->comments()->orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        // 入力値の検証
        $inputs = $this->validate([
            'body' => 'required|max:1000',
        ]);

        // 新規コメントの作成
        $comment=Comment::create([
            'body'=>$inputs['body'],
            'user_id'=>auth()->user()->id,
            'post_id'=>$this->post->id
        ]);

        $commentUser = $comment->post->user->email;
        $post = $comment->post;
        if ($commentUser != auth()->user()->email) {
            Mail::to($commentUser)->send(new ContactForm($inputs, $post));
        }

        // 入力欄をクリアし、フラッシュメッセージをセット
        $this->reset('body');
        $this->loadComments();
        session()->flash('message', 'コメントが送信されました。');

    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
