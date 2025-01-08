<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentNotification;

class IndexEvents extends Component
{
    public $comments;
    public $comment;
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->comments = $event->comments()->with('authorable')->get();    }

    public function submit()
    {
        $guard = null;
        if (auth('super_admin')->check()) {
            $guard = 'super_admin';
            $user = auth('super_admin')->user();
        } elseif (auth('branch')->check()) {
            $guard = 'branch';
            $user = auth('branch')->user();
        } elseif (auth('volunteer')->check()) {
            $guard = 'volunteer';
            $user = auth('volunteer')->user();
        }

        DB::beginTransaction();

        try {
            // إنشاء التعليق
            $comment = new Comment();
            $comment->body = $this->comment;
            $comment->authorable_type = get_class($user); 
            $comment->authorable_id = $user->id;
            $comment->event_id = $this->event->id;
            $comment->save();

            // تحديث قائمة التعليقات
            $this->comments = $this->event->comments()->with('authorable')->get();
            $this->reset('comment');
// 
            // // إشعار جميع المتطوعين الآخرين
            // $this->event->volunteers->each(function ($volunteer) use ($comment) {
            //     if ($volunteer->id !== $comment->authorable_id) {
            //         $volunteer->notify(new NewCommentNotification($comment));
            //     }
            // });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء إضافة التعليق. يرجى المحاولة مرة أخرى.');
        }
    }

    public function render()
    {
        return view('livewire.index-events');
    }
}
