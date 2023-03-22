<x-main-card>
    ರಶೀದಿಗಳು ದಿನಾಂಕವಾರು
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <form method="post" action="{{ route('fees.receiptToday') }}">
        @csrf
        <div class="flex justify-around items-center">
            <div class="m-2">
                <x-label value="ವಿಭಾಗ" />
                <select name="section" id="section">
                    <option value="0">ಎಲ್ಲಾ</option>
                    <option value="1">ಪ್ರಾಥಮಿಕ</option>
                    <option value="2">ಪ್ರೌಡ</option>
                </select>
            </div>

            <div class="m-2">
                <x-label value="ದಿನಾಂಕ" />
                <x-input type="date" name="date" required />
            </div>
            <x-button-primary value="ಸಲ್ಲಿಸು" class="h-11" />

        </div>
    </form>

    <form method="post" action="{{ route('fees.receiptBetweenDates') }}">
        @csrf
        <div class="flex justify-around items-center mt-32">
            <div class="m-2">
                <x-label value="ವಿಭಾಗ" />
                <select name="section" id="section1">
                    <option value="0">ಎಲ್ಲಾ</option>
                    <option value="1">ಪ್ರಾಥಮಿಕ</option>
                    <option value="2">ಪ್ರೌಡ</option>
                </select>
            </div>

            <div class="m-2">
                <x-label value="ದಿನಾಂಕ" />
                <div class="flex space-x-2">
                    <x-input type="date" name="from_date" required />
                    <x-input type="date" name="to_date" required />
                </div>
            </div>

            <x-button-primary value="ದಿನಾಂಕಗಳ ನಡುವೆ" class="h-11" />

        </div>
    </form>
</x-main-card>

<script>
    $("#section").select2()
    $("#section1").select2()
</script>
