
<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>
<x-main-card>
    ಸಾಮಾನ್ಯ ರಸೀದಿಗಳು
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <form action="{{route('general.receipt')}}" method="post">
        @csrf
        <div class="flex justify-around items-center">
            <div class="m-2">
                <x-label value="Receipt Date" />
                <x-input type="date" required value="{{ date('Y-m-d') }}" name="date" />
            </div>
            <div class="m-2">
                <x-label value="ರಶೀದಿ ಮೊತ್ತ" />
                <x-input type="number" required name="amount" />
            </div>
            <div class="m-2">
                <x-label value="ಹಣಕಾಸು ವರ್ಷ" />
                <select required name="year" id="year">
                    <option value="">ಹಣಕಾಸು ವರ್ಷ</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-center items-center">
            <div class="m-2 w-1/2">
                <x-label value="ಕಾರಣಕ್ಕಾಗಿ ರಶೀದಿ." />
                <x-input type="text" id="kancause" name="cause" placeholder="ಕಾರಣಕ್ಕಾಗಿ ರಶೀದಿ" />
            </div>
            <div class="mt-4 ml-4">
                <x-label value="" />
                <x-button-primary value="ಸಲ್ಲಿಸು" />
            </div>
        </div>
    </form>
</x-main-card>

<script>
    enableTransliteration(document.getElementById('kancause'), 'kn')
    $("#year").select2()
</script>
