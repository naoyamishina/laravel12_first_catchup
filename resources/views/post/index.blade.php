<x-layouts.app>

  {{-- 投稿一覧表示用のコード --}}
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          投稿の一覧
      </h2>
      <x-message :message="session('message')" type="success" />
      {{ $user->name }}さん、こんにちは！
      @foreach ($posts as $post)
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div
                    class="bg-white w-full  rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <div class="flex">
                                <div class="rounded-full w-12 h-12">
                                {{-- アバター表示 --}}
                                <img src="{{ asset('storage/avatar/' . ($post->user->avatar ?? 'user_default.jpg')) }}">
                                </div>
                            <h1
                                class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left pt-4">
                                <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                            </h1>
                        </div>
                        <hr class="w-full">
                        <p class="mt-4 text-gray-600 py-4">
                            {{ $post->body }}
                        </p>
                        <div class="text-sm font-semibold flex justify-end">
                            <p> {{ $post->user->name??'退会ユーザー' }} • {{ $post->created_at->diffForHumans() }}</p>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      @endforeach
  </div>
</x-layouts.app>
