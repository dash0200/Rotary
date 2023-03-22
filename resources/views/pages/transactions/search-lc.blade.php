<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>

<x-main-card>
    <h1>
        ವಿದ್ಯಾರ್ಥಿ ID ಪಡೆಯಿರಿ
    </h1>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex flex-col items-center mt-6">

        <div class="flex space-x-2 items-center">
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
        </div>

        <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getByNameYear()" />

    </div>
    <div class="mt-10 flex justify-center">OR</div>
    <div class="flex flex-col space-y-4">
        <div>
            <x-label value="STS" />
            <x-input type="text" id="sts" placeholder="STS" />
            <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getBysts()" />
        </div>
        <div class="mt-10 flex justify-center">OR</div>
        <div>
            <x-label value="ನೋಂದಣಿ ID" />
            <x-input type="text" id="id" placeholder="ನೋಂದಣಿ ID" />
            <x-button-primary value="ಪಡೆಯಿರಿ" onclick="getById()" />
        </div>
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
                    ಮಧ್ಯದ ಹೆಸರು
                </x-th>
                <x-th>
                    ಉಪನಾಮ
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
    $("#year").select2();
    enableTransliteration(document.querySelector("input[name='name']"), 'kn')
    function getById() {
        $.ajax({
            type: "get",
            url: "{{ route('trans.getByID') }}",
            data: {
                id: $("#id").val(),
            },
            dataType: "json",
            success: function(res) {
                console.log(res);
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
                    </tr>
                        `
                )

                if (res.exist == 1) {
                    $("#byId tr").append(
                        `
                    <x-td>
                        <form action="{{ route('trans.printLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="PRINT" />
                        </form>
                    </x-td>
                    <x-td>
                        <form action="{{ route('trans.printDuplicateLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="Duplicate PRINT" />
                        </form>
                    </x-td>
                    `
                    )
                }

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
                    
                    </tr>
                        `
                )

                if (res.exist == 1) {
                    $("#byId tr").append(
                        `
                    <x-td>
                        <form action="{{ route('trans.printLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="PRINT" />
                        </form>
                    </x-td>
                    <x-td>
                        <form action="{{ route('trans.printDuplicateLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res.id}" hidden>
                            <x-button-primary value="Duplicate PRINT" />
                        </form>
                    </x-td>
                    `
                    )
                }
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
                   
                    </tr>
                        `
                    )

                    if (res[i].exist == 1) {
                        $("#byId tr").append(
                            `
                    <x-td>
                        <form action="{{ route('trans.printLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res[i].id}" hidden>
                            <x-button-primary value="PRINT" />
                        </form>
                    </x-td>
                    <x-td>
                        <form action="{{ route('trans.printDuplicateLC') }}" method="post">
                            @csrf
                            <input type="text" name="id" value="${res[i].id}" hidden>
                            <x-button-primary value="Duplicate PRINT" />
                        </form>
                    </x-td>
                    `
                        )
                    }
                }
            }
        });
    }
</script>
