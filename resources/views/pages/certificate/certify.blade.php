<x-main-card>
    ಜನನ ಪ್ರಮಾಣಪತ್ರ
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex justify-between items-center">
        <div class="m-2">
            <x-label value="ತರಗತಿ" />
            <select name="class" id="class" required class="{{ $errors->has('class') ? 'is-invalid' : '' }}">
                <option value="">ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div id="pdf">
            @if ($print == true)
                <a href="{{ route('certificate.pdfCertify', ['id' => $id]) }}" target="_blank">
                    <x-button-success value="GET PDF" />
                </a>
            @else
                ದಾಖಲೆಯ ಪ್ರಕಾರ ವಿವರಗಳು ಕೆಳಗಿನಂತಿದೆ
            @endif
        </div>
    </div>

    <div class="w-4/5 flex space-x-6 items-center">
        <div>ನಲ್ಲಿ ಅಧ್ಯಯನ ಮಾಡುತ್ತಿದ್ದಾರೆ</div>
        <div>
            <x-input type="text" value="{{ $studying_in }}" id="std" disabled />
        </div>
        <div>
            <x-button-primary value="SAVE" onclick="saveStd('{{ $id }}')" />
        </div>
    </div>

    <div class="mt-11">
        ದಾಖಲೆಯ ಪ್ರಕಾರ ವಿವರಗಳು ಕೆಳಗಿನಂತಿದೆ

        <div>
            ಲ್ಲಿ ಅಧ್ಯಯನ ಮಾಡುತ್ತಿದ್ದಾರೆ : <b>{{ $Rstudying_in }}</b>
        </div>
    </div>
</x-main-card>

<script>
    $("#class").select2();

    $("#class").on("select2:select", function(e) {
        $("#std").val(e.params.data.text);
    });

    function saveStd(id) {
        $.ajax({
            type: "post",
            url: "{{ route('certificate.saveCertify') }}",
            data: {
                id: id,
                std: $("#std").val(),

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
                    <x-button-primary value="SAVE" onclick="saveStd('{{ $id }}')" />
                    `
                );
                location.reload();
            }
        });
    }
</script>
