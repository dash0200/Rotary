<x-main-card>
    ಬೋನಾಫೈಡ್ ಪ್ರಮಾಣಪತ್ರ
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex justify-between items-center">
        <div class="flex">
            <div class="m-2">
                <x-label value="ತರಗತಿಯಿಂದ" />
                <select name="class" id="class" required class="{{ $errors->has('class') ? 'is-invalid' : '' }}">
                    <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex">
            <div class="m-2">
                <x-label value="ತರಗತಿಗೆ" />
                <select name="ac_year" id="year" class="w-full" required>
                    <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="pdf">
            @if ($print == true)
                <a href="{{ route('certificate.pdfBonafied', ['id' => $student->id]) }}" target="_blank">
                    <x-button-success value="GET PDF" />
                </a>
            @else
            PDF ಪಡೆಯಲು ಕೆಳಗಿನ ಮಾಹಿತಿಯನ್ನು ಉಳಿಸಿ
            @endif
        </div>

    </div>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>


    <div class="mt-10 w-full space-y-4">
        <div class="flex items-center">
            <div class="mr-4"> ಕುಮಾರ್ / ಕುಮಾರಿ</div>
            <div>
                <x-input type="text" disabled
                    value="{{ $student->name }} {{ $student->fname }} {{ $student->lname }}" />
            </div>
            <div class="mr-4 ml-4"> <x-input type="text" disabled
                    value="{{ $student->fname }} {{ $student->lname }}" /></div>
            <div>
                ರವರ ಮಗ / ಮಗಳು
            </div>
            <div class="ml-2">ನಮ್ಮ ಶಾಲೆಯ ವಿದ್ಯಾರ್ಥಿ.</div>
        </div>

        <div class="flex items-center">
            <div class="mr-4"> ಅವನು / ಅವಳು </div>
            <div>
                <x-input disabled type="text" id="std" value="{{ $standard }}" />
            </div>
            <div class="ml-2 mr-2">ಈ ತರಗತಿಯಲ್ಲಿ ಓಡುತಿದ್ದಾರೆ.  </div>
            <div>
                <x-input type="text" disabled id="yr" value="{{ $acaYear }}" />
            </div>
            <div>
                ಈ ಶೈಕ್ಷಣಿಕ ವರ್ಷದಲ್ಲಿ 
            </div>
        </div>

        <div class="flex items-center">
            <div class="mr-4">ಅವನ/ಅವಳ ರಿಜಿಸ್ಟರ್ ಸಂಖ್ಯೆ</div>
            <div>
                <x-input disabled type="text" value="{{ $student->id }}" />
            </div>
        </div>

        <div class="flex justify-center w-full" id="save">
            <x-button-primary value="ಉಳಿಸಿ" onclick="saveStd('{{ $student->id }}')" />
        </div>
    </div>

    <div class="mt-11">
        ದಾಖಲೆಯ ಪ್ರಕಾರ

        <b>{{ $Rstandard }}</b>ನಲ್ಲಿ ಅಧ್ಯಯನ ಮಾಡುತ್ತಿದ್ದಾರೆ  :<b>{{ $RacaYear }}</b> ಶೈಕ್ಷಣಿಕ ವರ್ಷಕ್ಕೆ
    </div>

</x-main-card>

<script>
    $("#class").select2();
    $("#year").select2();

    $("#class").on("select2:select", function(e) {
        $("#std").val(e.params.data.text);
    });

    $("#year").on("select2:select", function(e) {
        $("#yr").val(e.params.data.text);
    });

    function saveStd(id) {

        $.ajax({
            type: "post",
            url: "{{ route('certificate.saveBonafied') }}",
            data: {
                id: id,
                std: $("#std").val(),
                year: $("#yr").val(),

            },
            beforeSend: function(data) {
                $("#save").html("");
                $("#save").append(
                    `
                    <x-loading-button value="saving" />
                    `
                );
            },
            dataType: "json",
            success: function(res) {
                $("#save").html("");
                $("#save").append(
                    `
                    <x-button-primary value="ಉಳಿಸಿ" onclick="saveStd('{{ $student->id }}')" />
                    `
                );
                location.reload();
            }
        });
    }
</script>
