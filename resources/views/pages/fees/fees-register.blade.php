<x-main-card>
    ಶುಲ್ಕ ನೋಂದಣಿ
    <div class="w-full bg-gray-200" style="height: 1px;"></div>


    <form method="post" action="{{route('fees.pdfFeesRegister')}}">
        @csrf
    <div class="flex justify-around">
        <div class="m-2">
            <x-label value="ಶೈಕ್ಷಣಿಕ ವರ್ಷ" />
            <select name="year" id="year" required>
                <option value="">ವರ್ಷವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>

        <div class="m-2">
            <x-label value="ವರ್ಗ" />
            <select name="class" id="class" required>
                <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
            </select>
        </div>

        <x-button-primary value="ಸಲ್ಲಿಸು" />
    </div>
    </form>
</x-main-card>
<script>
    $("#year").select2()
    $("#class").select2()
</script>