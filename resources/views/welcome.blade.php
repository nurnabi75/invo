<x-guest-layout>
    <div class="flex justify-between items-center flex-col">
        <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#0f766f" fill-opacity="1"
                    d="M0,160L12,176C24,192,48,224,72,234.7C96,245,120,235,144,197.3C168,160,192,96,216,90.7C240,85,264,139,288,176C312,213,336,235,360,240C384,245,408,235,432,224C456,213,480,203,504,192C528,181,552,171,576,160C600,149,624,139,648,149.3C672,160,696,192,720,181.3C744,171,768,117,792,96C816,75,840,85,864,90.7C888,96,912,96,936,117.3C960,139,984,181,1008,208C1032,235,1056,245,1080,208C1104,171,1128,85,1152,85.3C1176,85,1200,171,1224,192C1248,213,1272,171,1296,138.7C1320,107,1344,85,1368,101.3C1392,117,1416,171,1428,197.3L1440,224L1440,0L1428,0C1416,0,1392,0,1368,0C1344,0,1320,0,1296,0C1272,0,1248,0,1224,0C1200,0,1176,0,1152,0C1128,0,1104,0,1080,0C1056,0,1032,0,1008,0C984,0,960,0,936,0C912,0,888,0,864,0C840,0,816,0,792,0C768,0,744,0,720,0C696,0,672,0,648,0C624,0,600,0,576,0C552,0,528,0,504,0C480,0,456,0,432,0C408,0,384,0,360,0C336,0,312,0,288,0C264,0,240,0,216,0C192,0,168,0,144,0C120,0,96,0,72,0C48,0,24,0,12,0L0,0Z">
                </path>
            </svg>
        </div>
        <div class="text-center flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <img src="{{ asset('img/invo-mate.png') }}" class="w-20" alt="">
            <h2 class="font-bold text-6xl">INVO</h2>
            </div>
            <h3 class="text-xl">freelancer invoice helper</h3>
           <div class="flex space-x-3">
            <a href="{{ route('login') }}"
            class="border border-orange-400 px-5 py-1 mt-3 hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Login</a>
            <a href="{{ route('register') }}"
            class="border border-orange-400 px-5 py-1 mt-3 hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Register</a>
           </div>
        </div>
        <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#0f766f" fill-opacity="1"
                    d="M0,160L14.1,144C28.2,128,56,96,85,112C112.9,128,141,192,169,213.3C197.6,235,226,213,254,
                    213.3C282.4,213,311,235,339,245.3C367.1,256,395,256,424,256C451.8,256,480,256,508,234.7C536.5,
                    213,565,171,593,144C621.2,117,649,107,678,112C705.9,117,734,139,762,176C790.6,213,819,267,847,
                    245.3C875.3,224,904,128,932,112C960,96,988,160,1016,170.7C1044.7,181,1073,
                    139,1101,133.3C1129.4,128,1158,160,1186,144C1214.1,128,1242,64,1271,80C1298.8,96,1327,192,1355,
                    218.7C1383.5,245,1412,203,1426,181.3L1440,160L1440,320L1425.9,320C1411.8,320,1384,320,1355,
                    320C1327.1,320,1299,320,1271,320C1242.4,320,1214,320,1186,320C1157.6,320,1129,320,1101,320C1072.9,
                    320,1045,320,1016,320C988.2,320,960,320,932,320C903.5,320,875,320,847,320C818.8,320,791,320,762,320C734.1,
                    320,706,320,678,320C649.4,320,621,320,593,320C564.7,320,536,320,508,320C480,320,452,320,424,320C395.3,320,367,
                    320,339,320C310.6,320,282,320,254,320C225.9,320,198,320,169,320C141.2,320,113,320,85,320C56.5,320,28,320,14,320L0,320Z">
                </path>
            </svg>
        </div>
    </div>
</x-guest-layout>
