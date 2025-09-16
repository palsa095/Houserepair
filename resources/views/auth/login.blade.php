<x-guest-layout>
  {{-- Styles khusus: wavy bg + glass card + underline inputs --}}
  <style>
    .wave-lines {
      position: absolute;
      inset: 0;
      pointer-events: none;
      opacity: .22
    }

    .glass {
      background: rgba(0, 0, 0, .45);
      backdrop-filter: blur(6px)
    }

    .card-ring {
      box-shadow: 0 10px 30px rgba(0, 0, 0, .35), inset 0 0 0 1px rgba(16, 185, 129, .18)
    }

    .line-input {
      width: 100%;
      background: transparent;
      border: 0;
      border-bottom: 1px solid rgba(255, 255, 255, .45);
      color: #e5e7eb
    }

    .line-input::placeholder {
      color: rgba(229, 231, 235, .7)
    }

    .line-input:focus {
      outline: none;
      border-bottom-color: #86efac;
      box-shadow: 0 1px 0 0 rgba(134, 239, 172, .9)
    }

    .dotted {
      background: linear-gradient(to right, transparent 0, transparent 8px, rgba(255, 255, 255, .5) 8px, rgba(255, 255, 255, .5) 9px) 0 100%/12px 1px repeat-x;
      height: 1px
    }
  </style>

  <div class="relative min-h-screen overflow-hidden bg-emerald-950">
    {{-- Wavy background --}}
    <svg class="wave-lines" viewBox="0 0 1200 800" preserveAspectRatio="none">
      <defs>
        <linearGradient id="lg" x1="0" x2="1" y1="0" y2="1">
          <stop offset="0%" stop-color="#16a34a" />
          <stop offset="100%" stop-color="#0f5132" />
        </linearGradient>
      </defs>
      @for ($y = 20; $y <= 800; $y += 28)
        <path d="M0 {{ $y }} C 200 {{ $y - 18 }}, 400 {{ $y + 18 }}, 600 {{ $y - 8 }}
                 S 1000 {{ $y + 22 }}, 1200 {{ $y - 6 }}" fill="none" stroke="url(#lg)" stroke-width="1" />
      @endfor
    </svg>

    {{-- Centered card --}}
    <div class="glass card-ring relative z-10 mx-auto mt-10 w-[min(92%,780px)] rounded-[18px] p-8">
      {{-- Header brand --}}
      <div class="mb-8 flex items-center gap-4">
        <img src="{{ asset('/auth-logo.png') }}" alt="House Repair" class="h-16 w-16 rounded-md bg-emerald-600/15 p-1.5">
        <div class="flex items-end gap-4">
          <span class="text-3xl font-extrabold tracking-tight text-white">House Repair</span>
          <span class="h-8 w-px bg-white/30"></span>
          <span class="pb-1 text-xl font-semibold text-white/90">LOGIN</span>
        </div>
      </div>

      {{-- status flash --}}
      <x-auth-session-status class="mb-4" :status="session('status')" />

      {{-- Form --}}
      <form method="POST" action="{{ route('login') }}" class="mx-auto w-full max-w-md space-y-5">
        @csrf

        {{-- Email --}}
        <div class="text-center">
          <input id="email" name="email" type="email" placeholder="Username or Email" value="{{ old('email') }}" class="line-input text-center" required autofocus autocomplete="username">
          <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-300" />
        </div>

        {{-- Password --}}
        <div class="pt-1 text-center">
          <input id="password" name="password" type="password" placeholder="Password" class="line-input text-center" required autocomplete="current-password">
          <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-300" />
        </div>

        {{-- Login button --}}
        <div class="pt-2 text-center">
          <button type="submit" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            Login
          </button>
        </div>

        {{-- Separator dotted + "or" --}}
        <div class="mx-auto my-2 w-72">
          <div class="dotted"></div>
          <div class="-mt-3 text-center text-xs text-gray-300">or</div>
        </div>

        {{-- Google button (ubah routenya sesuai Socialite kamu) --}}
        <div class="text-center">
          <a href="#" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="h-4 w-4" alt="">
            Login with Google
          </a>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>
