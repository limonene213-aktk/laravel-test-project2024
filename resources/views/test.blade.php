    @if (Route::has('login'))
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                ダッシュボード
            </a>
        @else
            @guest
                <p>
                    ログインしていません。
                </p>
            @endguest
            <a
                href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                ログイン
            </a>
            <div>
            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                  登録
                </a>
            @endif
        @endauth
    @endif


<div>
    <p>こんにちは</p>
<div>
@auth
    <p>
        {{Auth::user()->name}} さん、こんにちは。
    </p>
@endauth

@foreach ($users as $user)
    <p>
        id {{$user->id}}：{{$user->name}}：{{$user->email}}
    </p>
@endforeach

<script>
    //alert("この祠を壊したのは誰じゃ！？")
</script>

