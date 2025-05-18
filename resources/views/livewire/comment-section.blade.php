<div>
    <div class="mt-4 mb-12">
        @if (session()->has('message'))
            <div class="text-green-600 mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save">
            <textarea wire:model="body"
                class="bg-white w-full rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500"
                cols="30" rows="3" placeholder="コメントを入力してください"></textarea>
            <flux:button type="submit" class="float-right mr-4 mb-12">
                コメントする
            </flux:button>
        </form>
    </div>

    @foreach ($comments as $comment)
    <div class="bg-white w-full rounded-2xl px-10 py-2 shadow-lg mt-8 whitespace-pre-line">
        {{ $comment->body }}
        {{-- 追加・修正 --}}
        <div class="text-sm font-semibold flex items-center justify-end">
            {{-- アバター追加 --}}
            <span class="rounded-full w-12 h-12 mr-2">
                <img src="{{ asset('storage/avatar/' . ($comment->user->avatar ?? 'user_default.jpg')) }}" class="w-full h-full rounded-full">
            </span>
            <p class="pt-4 text-right">
                {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
            </p>
        </div>
        {{-- 追加・修正ここまで --}}
    </div>
    @endforeach
</div>
