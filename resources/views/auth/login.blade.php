<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <!-- Username Address -->
        <div>
            <div style="position: relative; display: flex; align-items: center; width: 100%;">
                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: rgba(255, 255, 255, 0.8); pointer-events: none; z-index: 10;">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <input id="username" 
                       type="text" 
                       name="username" 
                       value="{{ old('username') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="Username"
                       style="width: 100%; box-sizing: border-box; padding-left: 46px; padding-right: 16px; padding-top: 12px; padding-bottom: 12px; background-color: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.4) !important; border-radius: 12px !important; color: #ffffff !important; outline: none !important; font-size: 14px; box-shadow: none !important;" />
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-1 text-red-300 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div style="position: relative; display: flex; align-items: center; width: 100%;" x-data="{ show: false }">
                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: rgba(255, 255, 255, 0.8); pointer-events: none; z-index: 10;">
                    <i class="fas fa-lock text-sm"></i>
                </div>
                <input :type="show ? 'text' : 'password'" 
                       id="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="Password"
                       style="width: 100%; box-sizing: border-box; padding-left: 46px; padding-right: 46px; padding-top: 12px; padding-bottom: 12px; background-color: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.4) !important; border-radius: 12px !important; color: #ffffff !important; outline: none !important; font-size: 14px; box-shadow: none !important;" />
            
                <button type="button" @click="show = !show" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: rgba(255, 255, 255, 0.8); background: none; border: none; cursor: pointer; z-index: 10;">
                    <i class="fas text-sm" :class="show ? 'fa-eye' : 'fa-eye-slash'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-300 text-xs" />
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; justify-content: flex-start; font-size: 12px; color: white; padding-top: 4px;">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember" 
                       style="background-color: rgba(255, 255, 255, 0.15); border-color: rgba(255, 255, 255, 0.4);"
                       class="rounded text-blue-500 shadow-sm focus:ring-blue-400 focus:ring-offset-transparent w-4 h-4">
                <span class="ml-2 text-white/90">Remember me</span>
            </label>
        </div>

        <!-- Log In Button -->
        <div style="padding-top: 12px;">
            <button type="submit" style="width: 100%; box-sizing: border-box; padding: 12px 16px; background-color: #3b82f6 !important; border: none; border-radius: 12px; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                LOG IN
            </button>
        </div>
    </form>
</x-guest-layout>