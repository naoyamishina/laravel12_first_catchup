<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>猫のくらし</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @include('partials.head')

</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-blue-600 hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-red-600 hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex flex-col-reverse lg:flex-row max-w-4xl mx-auto w-full">
            {{-- 追加 --}}
            <!-- ヒーローセクション -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 w-full">
                <!-- テキスト部分 -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">猫のくらし</h1>
                    <p class="text-2xl text-gray-600 dark:text-gray-300 mb-6">
                        猫がいる暮らしって、たのしい？めんどくさい？<br>
                        日々の暮らしのなかで感じる猫への気持ち、つづってみませんか？<br>
                        猫を飼っている人も、飼っていない人も、ぜひお気軽にご参加ください。
                    </p>
                    <p class="mb-4 text-red-600 font-bold text-base">
                        会員募集中
                    </p>
                    <div class="flex justify-center lg:justify-start gap-4">
                        @guest
                            <a href="{{ route('login') }}" class="btnset bg-blue-600 hover:bg-blue-700">
                                ログイン
                            </a>
                            <a href="{{ route('register') }}" class="btnset bg-red-600 hover:bg-red-700">
                                登録する
                            </a>
                        @endguest
                    </div>
                </div>
        
                <!-- 画像部分 -->
                <div class="flex-1">
                    <img src="{{ asset('logo/top.png') }}" alt="猫の画像"
                         class="w-full mx-auto rounded-xl shadow-2xl transform hover:scale-105 transition duration-300 object-cover">
                </div>
            </div>
            {{-- 追加終わり --}}
            
        </main>
        
    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>
