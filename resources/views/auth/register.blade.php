<x-guest-layout>
  {{-- Styles sama seperti halaman login --}}
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
    {{-- Wavy bg --}}
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

    {{-- Card --}}
    <div class="glass card-ring relative z-10 mx-auto mt-10 w-[min(92%,780px)] rounded-[18px] p-8">
      <div class="mb-8 flex items-center gap-4">
        <img src="{{ asset('/auth-logo.png') }}" alt="House Repair" class="h-16 w-16 rounded-md bg-emerald-600/15 p-1.5">
        <div class="flex items-end gap-4">
          <span class="text-3xl font-extrabold tracking-tight text-white">House Repair</span>
          <span class="h-8 w-px bg-white/30"></span>
          <span class="pb-1 text-xl font-semibold text-white/90">REGISTER</span>
        </div>
      </div>

      {{-- Form --}}
      <form method="POST" action="{{ route('register') }}" class="mx-auto w-full max-w-md space-y-5">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          {{-- Left column --}}
          <div class="space-y-5">
            <div>
              <input id="name" name="name" type="text" class="line-input" placeholder="Full Name" value="{{ old('name') }}" required autofocus autocomplete="name">
              <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-300" />
            </div>

            <div>
              <input id="email" name="email" type="email" class="line-input" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
              <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-300" />
            </div>
          </div>

          {{-- Right column --}}
          <div class="space-y-5">
            <div>
              <input id="password" name="password" type="password" class="line-input" placeholder="Password" required autocomplete="new-password">
              <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-300" />
            </div>

            <div>
              <input id="password_confirmation" name="password_confirmation" type="password" class="line-input" placeholder="Confirm Password" required autocomplete="new-password">
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-300" />
            </div>
          </div>
        </div>

        {{-- Submit --}}
        <div class="pt-2 text-center">
          <button type="submit" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            Register
          </button>
        </div>

        {{-- Separator --}}
        <div class="mx-auto my-2 w-72">
          <div class="dotted"></div>
          <div class="-mt-3 text-center text-xs text-gray-300">or</div>
        </div>

        {{-- Google --}}
        <div class="text-center">
          <a href="#" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="h-4 w-4" alt="">
            Continue with Google
          </a>
        </div>

        {{-- Link to login --}}
        <div class="pt-3 text-center text-xs text-gray-300">
          Already have an account?
          <a href="{{ route('login') }}" class="underline decoration-emerald-400/70 underline-offset-4 hover:text-white">Log in</a>
        </div>
      </form>
    </div>

    <div class="h-10"></div>
  </div>
</x-guest-layout>
