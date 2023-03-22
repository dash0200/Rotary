<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>

<x-main-card>
    <h1>
        ನಕಲಿ ರಸೀದಿ
    </h1>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex items-center justify-around border p-4 mt-6">

        <div>
            <x-label value="ವಿದ್ಯಾರ್ಥಿಯ ಹೆಸರು" />
            <x-input type="text" id="name" name="name" placeholder="ವಿದ್ಯಾರ್ಥಿಯ ಹೆಸರು" />
        </div>

        <div>
            <x-label value="ಪ್ರವೇಶ ವರ್ಷ" />
            <select name="ac_year" id="year" class="w-full" required>
                <option value="">ಪ್ರವೇಶ ವರ್ಷ</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>

        <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getByNameYear()" />

    </div>


    <div class="mt-10 flex justify-center pb-10">OR</div>

    <div class="flex justify-around border p-4">

        <div class="w-1/4">
            <x-label value="STS" />
            <x-input type="text" id="sts" placeholder="STS" />
            <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getBysts()" />
        </div>
        <div class="w-13">
            <x-label value="ನೋಂದಣಿ ID" />
            <x-input type="text" id="id" placeholder="ನೋಂದಣಿ ID" />
            <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getById()" />
        </div>

    </div>

    <div class="p-4 border my-10 flex justify-around">
        <div>
            <x-label value="ಮೊದಲ ಹೆಸರು" />
            <x-input type="text" placeholder="ಮೊದಲ ಹೆಸರು" name="firstname" />
        </div>
        <div>
            <x-label value="ತಂದೆಯ ಹೆಸರು" />
            <x-input type="text" placeholder="ತಂದೆಯ ಹೆಸರು" name="fname" />
        </div>
        <div>
            <x-label value="ಕೊನೆಯ ಹೆಸರು" />
            <x-input type="text" placeholder="ಕೊನೆಯ ಹೆಸರು" name="lname" />
        </div>
        <div>
            <x-label value="ಹುಟ್ತಿದ ದಿನ" />
            <x-input type="date" placeholder="ಹುಟ್ತಿದ ದಿನ" name="dob" />
        </div>
        <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getByInfo()" />
    </div>

    <div>
        <x-table>
            <x-thead>
                <x-th>
                    ನೋಂದಣಿ ID
                </x-th>
                <x-th>
                    STS
                </x-th>
                <x-th>
                    ಹೆಸರು
                </x-th>
                <x-th>
                    ತಂದೆಯ ಹೆಸರು
                </x-th>
                <x-th>
                    ಕೊನೆಯ ಹೆಸರು
                </x-th>
                <x-th>
                    ಹುಟ್ತಿದ ದಿನ
                </x-th>
                <x-th>

                </x-th>
            </x-thead>

            <tbody id="byId">

            </tbody>
        </x-table>
    </div>

</x-main-card>

<script>
    enableTransliteration(document.querySelector("input[name='name']"), 'kn')
    enableTransliteration(document.querySelector("input[name='firstname']"), 'kn')
    enableTransliteration(document.querySelector("input[name='fname']"), 'kn')
    enableTransliteration(document.querySelector("input[name='lname']"), 'kn')
    $("#year").select2();

    function getById() {
        $.ajax({
            type: "get",
            url: "{{ route('trans.getByID') }}",
            data: {
                id: $("#id").val(),
            },
            dataType: "json",
            success: function(res) {
                $("#byId").html("")
                $("#byId").append(
                    `
                    <tr>
                    <x-td>
                        ${res.id}
                    </x-td>
                    <x-td>
                        ${res.sts}
                    </x-td>
                    <x-td>
                        ${res.name}
                    </x-td>
                    <x-td>
                        ${res.fname}
                    </x-td>
                    <x-td>
                        ${res.lname}
                    </x-td>
                    <x-td>
                        ${res.dob1}
                    </x-td>
                    <x-td>
                        <form action="{{ route('fees.stdReceiptID') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="Duplicate Receipt" />
                        </form>
                    </x-td>
                    </tr>
                        `
                )
            }
        });
    }

    function getBysts() {
        $.ajax({
            type: "get",
            url: "{{ route('trans.getBysts') }}",
            data: {
                id: $("#sts").val(),
            },
            dataType: "json",
            success: function(res) {
                $("#byId").html('')
                $("#byId").append(
                    `
                    <tr>
                    <x-td>
                        ${res.id}
                    </x-td>
                    <x-td>
                        ${res.sts}
                    </x-td>
                    <x-td>
                        ${res.name}
                    </x-td>
                    <x-td>
                        ${res.fname}
                    </x-td>
                    <x-td>
                        ${res.lname}
                    </x-td>
                    <x-td>
                        ${res.dob1}
                    </x-td>
                    <x-td>
                        <form action="{{ route('fees.stdReceiptID') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="Duplicate Receipt" />
                        </form>
                    </x-td></tr>
                        `
                )
            }
        });
    }

    function getByNameYear() {
        $.ajax({
            type: "get",
            url: "{{ route('trans.getByName') }}",
            data: {
                name: $("#name").val(),
                year: $("#year").val()
            },
            dataType: "json",
            success: function(res) {
                $("#byId").html('')
                console.log(res);
                for (let i = 0; i < res.length; i++) {
                    $("#byId").append(
                        `
                    <tr>
                    <x-td>
                        ${res[i].id}
                    </x-td>
                    <x-td>
                        ${res[i].sts}
                    </x-td>
                    <x-td>
                        ${res[i].name}
                    </x-td>
                    <x-td>
                        ${res[i].fname}
                    </x-td>
                    <x-td>
                        ${res[i].lname}
                    </x-td>
                    <x-td>
                        ${res[i].dob1}
                    </x-td>
                    <x-td>
                        <form action="{{ route('fees.stdReceiptID') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res[i].id}" hidden>
                            <x-button-primary value="Duplicate Receipt" />
                        </form>
                    </x-td></tr>
                        `
                    )
                }
            }
        });
    }

    function getByInfo() {

        $.ajax({
            type: "get",
            url: "{{ route('trans.getByInfo') }}",
            data: {
                name: $("input[name='name']").val(),
                fname: $("input[name='fname']").val(),
                lname: $("input[name='lname']").val(),
                dob: $("input[name='dob']").val(),
            },
            dataType: "json",
            success: function(res) {
                $("#byId").html('')
                console.log(res);
                for (let i = 0; i < res.length; i++) {
                    $("#byId").append(
                        `
                    <tr>
                    <x-td>
                        ${res[i].id}
                    </x-td>
                    <x-td>
                        ${res[i].sts}
                    </x-td>
                    <x-td>
                        ${res[i].name}
                    </x-td>
                    <x-td>
                        ${res[i].fname}
                    </x-td>
                    <x-td>
                        ${res[i].lname}
                    </x-td>
                    <x-td>
                        ${res[i].dob1}
                    </x-td>
                    <x-td>
                        <form action="{{ route('fees.stdReceiptID') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res[i].id}" hidden>
                            <x-button-primary value="Duplicate Receipt" />
                        </form>
                    </x-td></tr>
                        `
                    )
                }
            }
        });
    }
</script>
