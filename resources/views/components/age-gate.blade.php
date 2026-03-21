<!-- resources/views/components/age-gate.blade.php -->
<div x-data="{
    showGate: false,
    verifyAge() {
        localStorage.setItem('age_verified', 'true');
        this.showGate = false;
        document.body.classList.remove('overflow-hidden');
    },
    declineAge() {
        window.location.href = 'https://www.google.com';
    },
    init() {
        if (!localStorage.getItem('age_verified')) {
            this.showGate = true;
            document.body.classList.add('overflow-hidden');
        }
    }
}" x-show="showGate" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
    
    <!-- Backdrop blur -->
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal panel -->
    <div x-show="showGate"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         class="relative glassmorphism rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 text-center border-t border-white/20">
        
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mocha-accent/20 mb-6">
            <svg class="h-8 w-8 text-mocha-accent" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <h3 class="text-2xl font-serif font-bold text-white mb-2">Age Verification</h3>
        <p class="text-gray-300 text-sm mb-8">
            You must be of legal drinking age (18+) to enter this site. By entering, you confirm that you are at least 18 years old.
        </p>
        
        <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
            <button @click="verifyAge()" class="flex-1 bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 shadow-[0_0_15px_rgba(139,69,19,0.5)]">
                Yes, I am 18+
            </button>
            <button @click="declineAge()" class="flex-1 bg-mocha-secondary hover:bg-gray-800 border border-white/10 text-gray-300 font-medium py-3 px-4 rounded-lg transition-colors">
                No, I am under 18
            </button>
        </div>
        <p class="mt-6 text-xs text-gray-500">
            Enjoy responsibly.
        </p>
    </div>
</div>
