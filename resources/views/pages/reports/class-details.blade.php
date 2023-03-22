<x-main-card>
    ವರ್ಗ ವಿವರಗಳು
    <form action="{{route("report.detailsClass")}}" method="post">
        @csrf
<div class="flex justify-around">
        <div class="m-2 w-full">
            <x-label value="ತರಗತಿಗಳು" />
            <select name="class" id="class" required
                class="{{ $errors->has('class') ? 'is-invalid' : '' }} w-full">
                <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="m-2 w-full">
            <x-label value="ವರ್ಷ" />
            <select name="year" id="year" class="w-full" required>
                <option value="">ಶೈಕ್ಷಣಿಕ ವರ್ಷ</option>
                @foreach ($years as $year)
                    <option value="{{$year->id}}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="m-2 w-full">
            <x-label value="ಆಯ್ಕೆ ಮಾನದಂಡ" />
            <select name="critic" id="critic" class="w-full" required>
                <option value="">ಆಯ್ಕೆ ಮಾನದಂಡ</option>
                <option value="IN">ಒಳಗೆ</option>
                <option value="OUT">OUTಹೊರಗೆ</option>
                <option value="BOTH" selected>ಎರಡೂ</option>
            </select>
        </div>

        <div>
            <x-button-primary value="ಸಲ್ಲಿಸು" />
        </div>
</div>
</form>
</x-main-card>

<script>
    $("#class").select2()

    $("#year").select2()

    $("#critic").select2()
</script>