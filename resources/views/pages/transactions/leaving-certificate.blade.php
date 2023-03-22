<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>


<x-main-card>
    <div class="flex justify-between">
        <a href="{{ route('trans.searchLC') }}">
            <x-button-primary value="PRINT LC" />
        </a>

        <div class="text-orange-500" id="exist">

        </div>
    </div>
    <div>
        <x-label value="Register Number" />
        <select name="student" id="stdsearh" class="w-full">
            <option value="">Start Typing [ STS - Register_No, Name Father_Name Last_Name, (date_of_admission) ]
            </option>
        </select>
    </div>
    <div>
        <x-table>
            <x-thead>
                <x-th>
                    ನೋಂದಣಿ ಸಂಖ್ಯೆ
                </x-th>
                <x-th>
                    STS
                </x-th>
                <x-th>
                    ಹೆಸರು
                </x-th>
                <x-th>
                    ತಂದೆ ಹೆಸರು
                </x-th>
                <x-th>
                    ತಾಯಿ ಹೆಸರು
                </x-th>
                <x-th>
                    ಉಪನಾಮ
                </x-th>
                <x-th>
                    ಹುಟ್ತಿದ ದಿನ
                </x-th>
            </x-thead>
            <tbody id="adm">

            </tbody>
        </x-table>
    </div>


    <div>
        ಕೊನೆಯ ತರಗತಿ
        <x-table>
            <x-thead>
                <x-th>
                    ವರ್ಗ
                </x-th>
                <x-th>
                    ಶೈಕ್ಷಣಿಕ ವರ್ಷ
                </x-th>
            </x-thead>
            <tbody id="lastCls">

            </tbody>
        </x-table>
    </div>
    ಲೀವಿಂಗ್ ಸರ್ಟಿಫಿಕೇಟ್
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="flex flex-col space-y-4">
        <div class="flex space-x-2 mt-5 items-center justify-around">
            <div>
                <x-label value="ತರಗತಿಯವರೆಗೆ ಓದಿದೆ" />
                <select name="class" id="class" required>
                    <option value="">ವರ್ಗ ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                <span id="tillClassError" class="text-red-500"></span>
            </div>
            <div>
                <x-label value="ಶೈಕ್ಷಣಿಕ ವರ್ಷದವರೆಗೆ" />
                <select name="year" id="year" required>
                    <option value="">ವರ್ಷವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
                <span id="tillYearError" class="text-red-500"></span>
            </div>
        </div>

        <div class="flex justify-between mt-5 space-x-2">
            <div class="w-full">
                <x-label value="ಹೊರಡುವಾಗ ಓದುತ್ತಿದ್ದೆ" />
                <x-input name="wasStd" id="wasStd" placeholder="WAS STUDYING WHILE LEAVING" />
            </div>
            <div class="w-full">
                <x-label value="ಪ್ರಚಾರಕ್ಕೆ ಅರ್ಹತೆ ಇದೆಯೇ" />
                <x-input name="qualif" id="qualif" placeholder="WHETHER QUALIFIED FOR PROMOTION" />
            </div>
        </div>

        <div class="flex justify-between mt-5 space-x-2">
            <div class="w-full">
                <x-label value="ಕೊನೆಯ ಹಾಜರಾತಿ" />
                <x-input type="date" name="la" />
                <span id="laError" class="text-red-500"></span>
            </div>
            <div class="w-full">
                <x-label value="ಅರ್ಜಿಯ ದಿನಾಂಕ" />
                <x-input type="date" name="dop" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="w-full">
                <x-label value="L.C ವಿತರಿಸುವ ದಿನಾಂಕ" />
                <x-input type="date" name="doi" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="w-full">
                <x-label value="ಶಾಲೆಯನ್ನು ತೊರೆಯಲು ಕಾರಣ" />
                <x-input type="text" name="reason" value="ಪಾಲಕರ ವಿನಂತಿ" />
            </div>
        </div>

        <div class="flex justify-between mt-5 space-x-2">
            <div>
                <x-label value="ತರಗತಿಗೆ ಪ್ರವೇಶ ಪಡೆದಿದ್ದಾರೆ" />
                <x-input type="text" id="atc1" name="atc" />
            </div>

            <div>
                <x-label value="ಒಪ್ಪಿಕೊಂಡ ವರ್ಷ" />
                <x-input type="text" name="ay" />
            </div>

            <div>
                <x-label value="ಪ್ರವೇಶದ ದಿನಾಂಕ" />
                <x-input type="text" name="doa" />
            </div>

            <div>
                <x-label value="ನಲ್ಲಿ ಅಧ್ಯಯನ ಮಾಡಲಾಗುತ್ತಿದೆ" />
                <x-input type="text" id="stdin1" name="stdin" />
            </div>

            <div>
                <x-label value="ಪ್ರಸ್ತುತ ವರ್ಷ" />
                <x-input type="text" name="cy" value="{{ date('Y') }}" />
            </div>
        </div>

        <div class="flex mt-5 justify-between space-x-2">

            <div>
                <x-label value="ವಿದ್ಯಾರ್ಥಿಯ ಹೆಸರು" />
                <x-input type="text" id="name" />
            </div>

            <div>
                <x-label value="ತಂದೆಯ ಹೆಸರು" />
                <x-input type="text" id="father" />
            </div>

            <div>
                <x-label value="ತಾಯಿ ಹೆಸರು" />
                <x-input type="text" id="mother" />
            </div>

            <div>
                <x-label value="ಸುರ್ ಹೆಸರು" />
                <x-input type="text" id="sur" />
            </div>

        </div>

        <div class="flex mt-5 justify-center" id="save">

        </div>
    </div>
</x-main-card>

<script>
    $("#class").select2()
    $("#year").select2()
    enableTransliteration(document.getElementById('wasStd'), 'kn')
    enableTransliteration(document.getElementById('qualif'), 'kn')
    enableTransliteration(document.getElementById('atc1'), 'kn')
    enableTransliteration(document.getElementById('stdin1'), 'kn')


    function submitLC(id) {

        if ($("#class").val() == null || $("#class").val() == "" || $("#class").val() == undefined) {
            $("#tillClassError").text("Select Class")
            return
        } else {
            $("#tillClassError").text("");
        }

        if ($("#year").val() == null || $("#year").val() == "" || $("#year").val() == undefined) {
            $("#tillYearError").text("Select Year")
            return
        } else {
            $("#tillYearError").text("");
        }

        if ($("input[name='la']").val() == null || $("input[name='la']").val() == "" || $("input[name='la']").val() ==
            undefined) {
            $("#laError").text("Enter Last Attendance")
            return
        } else {
            $("#laError").text("");
        }

        $.ajax({
            type: "post",
            url: "{{ route('trans.saveLc') }}",
            data: {
                id: id,
                stdTill: $("#class").val(),
                tillYear: $("#year").val(),
                wasStd: $("input[name='wasStd']").val(),
                qualified: $("input[name='qualif']").val(),
                la: $("input[name='la']").val(),
                doa: $("input[name='doa']").val(),
                doi: $("input[name='doi']").val(),
                reason: $("input[name='reason']").val(),
            },
            dataType: "json",
            beforeSend: function() {
                $("#save").html('')
                $("#save").append(
                    `
                    <x-loading-button />
                    `
                );
            },
            success: function(res) {
                $("#save").html('')
                $("#save").append(
                    `
                    <x-button-primary class="w-1/4" value="SUBMIT" id="svBtn" onclick="submitLC('${id}', )" />
                    `
                );
            }
        });
    }

    $("#stdsearh").select2({
        ajax: {
            url: "{{ route('getStdId') }}",
            type: "get",
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    })

    $("#stdsearh").on("select2:select", function(e) {
        let data = e.params.data;
        $.ajax({
            type: "get",
            url: "{{ route('trans.getStuddent') }}",
            data: {
                id: data.id
            },
            dataType: "json",
            success: function(res) {
                console.log(res);

                if (res[0].deleted_at !== null) {
                    $("#exist").text(
                        `ಆಯ್ಕೆಯಾದ ವಿದ್ಯಾರ್ಥಿಗೆ LC ಈಗಾಗಲೇ ರಚಿಸಲಾಗಿದೆ, ನೀವು ಸಲ್ಲಿಸು ಕ್ಲಿಕ್ ಮಾಡಿದರೆ ಮಾಹಿತಿಯನ್ನು ನವೀಕರಿಸಲಾಗುತ್ತದೆ
                        (LC for the selected student has already been Generated if you click on submit the information will be update)`
                        )
                } else {
                    $("#exist").text("")
                }
                $("#adm").html('')
                $("#adm").append(
                    `
                    <x-body-tr>

                        <x-td>
                            ${res[0].id}
                        </x-td>

                        <x-td>
                            ${res[0].sts}
                        </x-td>

                        <x-td>
                            ${res[0].name}
                        </x-td>

                        <x-td>
                            ${res[0].fname}
                        </x-td>

                        <x-td>
                            ${res[0].mname}
                        </x-td>

                        <x-td>
                            ${res[0].lname}
                        </x-td>

                        <x-td>
                            ${res[0].dob1}
                        </x-td>
                        
                    </x-body-tr>
                    `
                )

                $("#lastCls").html('')
                $("#lastCls").append(
                    `
                    <x-body-tr>
                        <x-td>
                            ${res[1].std == '' ? '' : res[1].std.name}
                        </x-td>

                        <x-td>
                            ${res[1].yr == '' ? '' : res[1].aca_year.year}
                        </x-td>
                    </x-body-tr>
                    `
                )

                $("#save").append(
                    `
                    <x-button-primary class="w-1/4" value="SUBMIT" id="svBtn" onclick="submitLC('${res[0].id}', )" />
                    `
                )

                $("input[name='wasStd']").val(
                    `WAS STUDYING IN ${res[1] == '' ? '' : res[1].std.name} CLASS`)
                $("input[name='qualif']").val(`YES QUALIFIED FOR  ${res[2].name} CLASS`)
                $("input[name='atc']").val(`${res[0].classes.name}`)
                $("input[name='ay']").val(`${res[0].aca_year.year}`)
                $("input[name='doa']").val(`${res[0].doy}`)
                $("input[name='stdin']").val(`${res[1].std == '' ? '' : res[1].std.name}`)

                $("#name").val(`${res[0].name}`)
                $("#fname").val(`${res[0].fname}`)
                $("#mname").val(`${res[0].mname}`)
                $("#sur").val(`${res[0].lname}`)
            }
        });
    })
</script>
