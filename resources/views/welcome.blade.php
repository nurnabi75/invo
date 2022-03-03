<x-guest-layout>
    <div class="flex justify-between items-center flex-col">
        <div class="flex-1 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,160L0,128L57.6,
                128L57.6,224L115.2,224L115.2,96L172.8,96L172.8,128L230.4,128L230.4,320L288,320L288,288L345.6,288L345.6,128L403.2,
                128L403.2,160L460.8,160L460.8,32L518.4,32L518.4,320L576,320L576,192L633.6,192L633.6,256L691.2,256L691.2,320L748.8,
                320L748.8,320L806.4,320L806.4,96L864,96L864,64L921.6,64L921.6,64L979.2,64L979.2,96L1036.8,96L1036.8,160L1094.4,
                160L1094.4,224L1152,224L1152,128L1209.6,128L1209.6,32L1267.2,32L1267.2,128L1324.8,128L1324.8,320L1382.4,320L1382.4
                ,32L1440,32L1440,0L1382.4,0L1382.4,0L1324.8,0L1324.8,0L1267.2,0L1267.2,0L1209.6,0L1209.6,0L1152,0L1152,0L1094.4,
                0L1094.4,0L1036.8,0L1036.8,0L979.2,0L979.2,0L921.6,0L921.6,0L864,0L864,0L806.4,0L806.4,0L748.8,0L748.8,0L691.2,
                0L691.2,0L633.6,0L633.6,0L576,0L576,0L518.4,0L518.4,0L460.8,0L460.8,0L403.2,0L403.2,0L345.6,0L345.6,0L288,0L288,
                0L230.4,0L230.4,0L172.8,0L172.8,0L115.2,0L115.2,0L57.6,0L57.6,0L0,0L0,0Z"></path></svg>
        </div>
        <div class="text-center flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <img src="{{ asset('img/invo-mate.png') }}" class="w-20" alt="">
            <h2 class="font-bold text-6xl">INVO</h2>
            </div>
            <h3 class="text-xl">freelancer invoice helper</h3>
           <div class="flex space-x-3 justify-center">

            @auth
                <a href="{{ route('dashboard') }}"
                class="border border-orange-400 px-5 py-1 mt-3
                hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Dashboard</a>

                @else
                <a href="{{ route('login') }}"
                class="border border-orange-400 px-5 py-1 mt-3
                hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Login</a>
                <a href="{{ route('register') }}"
                class="border border-orange-400 px-5 py-1 mt-3
                hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Register</a>
             @endauth

           </div>
        </div>
        <div class="flex-1 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,256L0,64L48,64L48,
                224L96,224L96,128L144,128L144,32L192,32L192,256L240,256L240,288L288,288L288,0L336,0L336,64L384,64L384,32L432,32L432,
                160L480,160L480,32L528,32L528,160L576,160L576,128L624,128L624,128L672,128L672,256L720,256L720,288L768,288L768,288L816
                ,288L816,128L864,128L864,96L912,96L912,256L960,256L960,256L1008,256L1008,32L1056,32L1056,128L1104,128L1104,256L1152,
                256L1152,224L1200,224L1200,32L1248,32L1248,64L1296,64L1296,64L1344,64L1344,64L1392,64L1392,160L1440,160L1440,320L1392,
                320L1392,320L1344,320L1344,320L1296,320L1296,320L1248,320L1248,320L1200,320L1200,320L1152,320L1152,320L1104,320L1104,
                320L1056,320L1056,320L1008,320L1008,320L960,320L960,320L912,320L912,320L864,320L864,320L816,320L816,320L768,320L768,
                320L720,320L720,320L672,320L672,320L624,320L624,320L576,320L576,320L528,320L528,320L480,320L480,320L432,320L432,
                320L384,320L384,320L336,320L336,320L288,320L288,320L240,320L240,320L192,320L192,320L144,320L144,320L96,320L96,320L48,
                320L48,320L0,320L0,320Z"></path></svg>
        </div>
    </div>
</x-guest-layout>
