<x-main-card>
    ಕ್ಯಾರೆಕ್ಟರ್ ಸರ್ಟಿಫಿಕೇಟ್
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex justify-between items-center">
        <div class="flex">
            <div class="m-2">
                <x-label value="ತರಗತಿಯಿಂದs" />
                <select name="class" id="class_from" required class="{{ $errors->has('class') ? 'is-invalid' : '' }}">
                    <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="m-2">
                <x-label value="ತರಗತಿಗೆ" />
                <select name="class" id="class_to" required class="{{ $errors->has('class') ? 'is-invalid' : '' }}">
                    <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="pdf">
            @if ($print == true)
                <a href="{{ route('certificate.pdfCHaracter', ['id' => $student->id]) }}" target="_blank">
                    <x-button-success value="GET PDF" />
                </a>
            @else
            ದಾಖಲೆಯ ಪ್ರಕಾರ ವಿವರಗಳು ಕೆಳಗಿನಂತಿದೆ

            @endif
        </div>

    </div>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="flex">
        <div class="m-2">
            <x-label value="ವರ್ಷದಿಂದ" />
            <select name="ac_year" id="from_year" class="w-full" required>
                <option value="">ಶೈಕ್ಷಣಿಕ ವರ್ಷ</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>
        <div class="m-2">
            <x-label value="ವರ್ಷಕ್ಕೆ" />
            <select name="ac_year" id="to_year" class="w-full" required>
                <option value="">ಶೈಕ್ಷಣಿಕ ವರ್ಷ</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-10 w-full space-y-4">
        <div class="flex items-center">
            <div class="mr-4"> ಕುಮಾರ್ / ಕುಮಾರಿ.</div>
            <div>
                <x-input type="text" disabled
                    value="{{ $student->name }}.{{ $student->fname }}.{{ $student->lname }}" />
            </div>
            <div class="mr-4 ml-4"> <x-input type="text" disabled
                value="{{ $student->fname }}.{{ $student->lname }}" /></div>
            <div>
                ರವರ ಮಗ / ಮಗಳು
            </div>
            <div class="ml-2">ನಮ್ಮ ಶಾಲೆಯ ವಿದ್ಯಾರ್ಥಿ.</div>
        </div>

        <div class="flex items-center">
            <div class="mr-4"> ಅವನು / ಅವಳು</div>
            <div>
                <x-input disabled type="text" id="std_from" value="{{ $std_from }}" />
            </div>
            <div class="mr-4 ml-4"> ತರಗತಿಯಿಂದ </div>
            <div>
                <x-input type="text" disabled id="std_to" value="{{ $std_to }}" />
            </div>
            <div class="ml-2">ತರಗತಿ ವರೆಗೆ ನಮ್ಮ ಶಾಲೆಯಲ್ಲಿ ಓದಿದ್ದಾರೆ .</div>
        </div>

        <div class="flex items-center">
            <div class="mr-4">ಶೈಕ್ಷಣಿಕ ವರ್ಷದ</div>
            <div>
                <x-input type="text" disabled id="from_yr" value="{{ $from_year }}" />
            </div>
            <div class="mr-4 ml-4"> ರಿಂದ </div>
            <div>
                <x-input type="text" disabled id="to_yr" value="{{ $to_year }}" />
            </div>
            <div class="ml-2">ವರೆಗೆ.</div>
        </div>

        <div class="flex items-center">
            <div class="mr-4"> ಅವನ/ಅವಳ ರಿಜಿಸ್ಟರ್ ಸಂಖ್ಯೆ</div>
            <div>
                <x-input disabled type="text" value="{{ $student->id }}" />
            </div>
            <div class="mr-4 ml-4"> ಮತ್ತು ಅವನ/ಅವಳ ಜಾತಿ ಕೆಳಗಿನಂತಿದೆ</div>
        </div>

        <div class="flex justify-center w-full" id="save">
            <x-button-primary value="SAVE" onclick="saveStd('{{ $student->id }}')" />
        </div>
    </div>

    <div class="mt-11">
        ದಾಖಲೆಯ ಪ್ರಕಾರ ವಿವರಗಳು ಕೆಳಗಿನಂತಿದೆ
        <div>
            ತರಗತಿಯಿಂದ: <b>{{ $Rstd_from }}</b> ವರೆಗೆ <b>{{ $Rstd_to }}</b>
        </div>
        <div>
            ಶೈಕ್ಷಣಿಕ ವರ್ಷದಿಂದ : <b>{{ $Rfrom_year }}</b> ವರೆಗೆ <b>{{ $Rto_year }}</b>
        </div>
    </div>

</x-main-card>

<script>
    $("#class_from").select2();
    $("#to_year").select2();

    $("#class_to").select2();
    $("#from_year").select2();

    $("#class_from").on("select2:select", function(e) {
        $("#std_from").val(e.params.data.text);
    });

    $("#class_to").on("select2:select", function(e) {
        $("#std_to").val(e.params.data.text);
    });

    $("#from_year").on("select2:select", function(e) {
        $("#from_yr").val(e.params.data.text);
    });

    $("#to_year").on("select2:select", function(e) {
        $("#to_yr").val(e.params.data.text);
    });

    function saveStd(id) {

        $.ajax({
            type: "post",
            url: "{{ route('certificate.saveCharacterCertificate') }}",
            data: {
                id: id,
                from_year: $("#from_yr").val(),
                to_year: $("#to_yr").val(),
                std_from: $("#std_from").val(),
                std_to: $("#std_to").val(),
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
                    <x-button-primary value="SAVE" onclick="saveStd('{{ $student->id }}')" />
                    `
                );
                location.reload();
            }
        });
    }
</script>
