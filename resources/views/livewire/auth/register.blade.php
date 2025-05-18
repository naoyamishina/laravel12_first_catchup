<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.auth')] class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $avatar; 

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($this->avatar) {
            // 現在の日付と時刻（秒まで）を取得
            $timestamp = now()->format('YmdHis');
            // 元のファイル名を取得
            $originalName = $this->avatar->getClientOriginalName();
            // 新しいファイル名を生成
            $filename = $timestamp . '_' . $originalName;
            // public/avatar に保存（disk名は public）
            $this->avatar->storeAs('avatar', $filename, 'public');
            // データベースに保存するためにパスとしてファイル名のみをセット
            $validated['avatar'] = $filename;
        } else {
            // アップロードがなければ、avatar キーを除外
            unset($validated['avatar']);
        }

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));
        $user->roles()->attach(2);

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div>
        <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>

        @if ($avatar)
            <div class="my-2">
                <p class="text-sm text-gray-500 mb-1">プレビュー：</p>
                <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar Preview" class="w-50 rounded-full">
            </div>
        @endif
        <flux:input type="file" id="avatar" wire:model="avatar" class="mt-1 block w-full" />

        {{-- アップロード中の表示 --}}
        <div wire:loading wire:target="avatar" class="text-sm text-gray-500 mt-1">
            アップロード中...
        </div>

        @error('avatar')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
