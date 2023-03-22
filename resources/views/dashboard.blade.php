<x-main-card>

    <div class="flex justify-center w-full">
        <div class="flex flex-col items-center pb-10">
            <img class="mb-3 w-24 h-24 rounded-full shadow-lg" src="{{ asset('logo.png') }}" alt="Bonnie image">
            <span>ಈ ಶಾಲೆಯಲ್ಲಿ ನೋಂದಾಯಿಸಲಾದ ಒಟ್ಟು ವಿದ್ಯಾರ್ಥಿಗಳು</span>
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $students }}</h5>
        </div>
    </div>

    <div class="flex flex-col">
        <div>
            ಶೈಕ್ಷಣಿಕ ವರ್ಷ - <b>{{ $year }}</b> - ತರಗತಿಗಳ ಪ್ರಕಾರ ಒಟ್ಟು ವಿದ್ಯಾರ್ಥಿಗಳು
        </div>
        <div class="flex justify-around flex-wrap mt-10">
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">ನರ್ಸರಿ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $nursery }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">ಎಲ್.ಕೆ.ಜಿ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $lkg }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">ಯುಕೆಜಿ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $ukg }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">ಯುಕೆಜಿ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $first }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">2ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $second }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">3ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $third }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">4ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $fourth }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">5ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $fifth }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">6ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $sixth }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">7ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $seventh }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">8ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $eighth }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">9ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $nineth }}</h5>
            </div>
            <div class="flex flex-col items-center pb-10">

                <span class="uppercase">10ನೇ</span>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $tenth }}</h5>
            </div>
        </div>

        <div class="flex flex-col items-center">
            <div>ಶೈಕ್ಷಣಿಕ ವರ್ಷದ ಒಟ್ಟು ವಿದ್ಯಾರ್ಥಿಗಳು: <b>{{ $year }}</b></div>

            <div class="flex justify-center font-bold">
                {{ $totalStudentThisYear }}
            </div>
        </div>
    </div>

</x-main-card>
