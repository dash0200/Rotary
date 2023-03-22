<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>

<x-main-card>
    ವಿದ್ಯಾರ್ಥಿ ಪ್ರವೇಶ ಮಾಹಿತಿಯನ್ನು ನವೀಕರಿಸಿ
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <form action="{{ route('trans.saveAdmission') }}" method="post">
        @csrf
        <input type="text" value="{{ $std->id }}" name="id" hidden>
        <div class="flex flex-col justify-around">
            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="STS" />
                    <x-input type="text" name="sts" value="{{ $std->sts }}" placeholder="SST" />
                </div>

                <div class="m-2 w-full">
                    <x-label value="ವಿದ್ಯಾರ್ಥಿಯ ಹೆಸರು" />
                    <x-input type="text" placeholder="ವಿದ್ಯಾರ್ಥಿಯ ಹೆಸರು" value="{{ $std->name }}"
                        class="{{ $errors->has('fname') ? 'is-invalid' : '' }}" name="fname" required
                        class="alphaonly" />
                </div>

                <div class="m-2 w-full">
                    <x-label value="ನಗರ" />
                    <select name="city" id="city" required class="w-full">
                        <option value="">ನಗರವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" @if ($std->city == $district->id) selected @endif>
                                {{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ಪ್ರವೇಶ ದಿನಾಂಕ" />
                    <x-input type="date" name="admDate" value="{{ $std->doa }}"
                        class="{{ $errors->has('admDate') ? 'is-invalid' : '' }}" required
                        placeholder="Date of Admission" />
                </div>

                <div class="m-2 w-full">
                    <x-label value="ತಂದೆಯ ಹೆಸರು" />
                    <x-input type="text" placeholder="ತಂದೆಯ ಹೆಸರು" value="{{ $std->fname }}" name="father"
                        class="alphaonly" />
                </div>

                <div class="m-2 w-full">
                    <x-label value="ದೂರವಾಣಿ ಸಂಖ್ಯೆ" />
                    <x-input type="text" placeholder="Phone" value="{{ $std->phone }}" name="phone"
                        class="numOnly" />
                </div>
            </div>

            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ತರಗತಿಗಳು" />
                    <select name="class" id="class" required
                        class="{{ $errors->has('class') ? 'is-invalid' : '' }} w-full">
                        <option value="">ಆಯ್ಕೆಮಾಡಿ ತರಗತಿಗಳು</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" @if ($std->class == $class->id) selected @endif>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ತಾಯಿಯ ಹೆಸರು" />
                    <x-input type="text" placeholder="ತಾಯಿಯ ಹೆಸರು" value="{{ $std->mname }}" name="mname"
                        class="alphaonly" />
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಮೊಬೈಲ್ ನಂಬರ" />
                    <x-input type="text" placeholder="ಮೊಬೈಲ್ ನಂಬರ" value="{{ $std->mobile }}" name="mobile"
                        class="numOnly" />
                </div>
            </div>

            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ವಿಳಾಸ" />
                    <textarea class="resize-y w-full h-11 rounded-md" id="address" name="address" required>@if (old('address') == null){{ $std->address }}@else{{ old('address') }}@endif</textarea>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಉಪ ಹೆಸರು" />
                    <x-input type="text" placeholder="ಉಪ ಹೆಸರು" value="{{ $std->lname }}" name="surname"
                        class="alphaonly" />
                </div>

                <div class="m-2 w-full">
                    <x-label value="ಹುಟ್ತಿದ ದಿನ" />
                    <x-input type="date" value="{{ $std->dob1 }}" placeholder="DOB" name="dob" required
                        max="{{ date('Y-m-d') }}" />
                </div>
            </div>

            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="Birth Place" />
                    <x-input type="text" placeholder="ಹುಟ್ಟಿದ ಸ್ಥಳ" value="{{ $std->birth_place }}"
                        name="birthPlace" class="alphaonly" />
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಜಾತಿ" />
                    <select name="caste" id="caste" class="w-full" required>
                        <option value="">ಜಾತಿ ಆಯ್ಕೆಮಾಡಿ</option>
                        @foreach ($castes as $caste)
                            <option value="{{ $caste->id }}" @if ($std->caste == $caste->id) selected @endif>
                                {{ $caste->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಲಿಂಗ" />
                    <div class="flex justify-around">
                        <div class="form-check">
                            <input
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                value="1" type="radio" name="gender" id="male"
                                @if ($std->gender == 1) checked @endif>
                            <label class="form-check-label inline-block text-gray-800" for="male">
                                ಪುರುಷ
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                value="0" type="radio" name="gender" id="female"
                                @if ($std->gender == 0) checked @endif>
                            <label class="form-check-label inline-block text-gray-800" for="female">
                                ಹೆಣ್ಣು
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ರಾಜ್ಯ" />
                    <select name="states" id="states" class="w-full">
                        <option value="">ರಾಜ್ಯವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if ($std->state == $state->id) selected @endif>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                    <input id="slectedState" type="text" hidden />
                </div>
                <div class="m-2 w-full ">
                    <x-label value="ಉಪ ಜಾತಿ" />
                    <select name="subc" id="subc" class="w-full">
                        @foreach ($std->sub_castes as $sub_caste)
                            <option value="{{ $sub_caste->id }}" @if ($std->sub_caste == $sub_caste->id) selected @endif>
                                {{ $sub_caste->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಅಂಗವಿಕಲತೆ ?" />
                    <div class="flex justify-around">
                        <div class="form-check">
                            <input
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                value="0" type="radio" checked name="handicap" id="no"
                                @if ($std->handicap == 0) checked @endif>
                            <label class="form-check-label inline-block text-gray-800" for="no">
                                ಇಲ್ಲ
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                value="1" type="radio" name="handicap" id="yes"
                                @if ($std->handicap == 1) checked @endif>
                            <label class="form-check-label inline-block text-gray-800" for="yes">
                                ಹೌದು
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ಜಿಲ್ಲೆ" />
                    <select name="district" id="district" class="w-full">
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" @if ($std->dist == $district->id) selected @endif>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ವರ್ಗ" />
                    <select name="cat" id="cat" class="w-full">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @if ($std->category == $cat->id) selected @endif>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ವರ್ಷ" />
                    <select name="ac_year" id="year" class="w-full" required>
                        <option value="">ಶೈಕ್ಷಣಿಕ ವರ್ಷ</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->id }}" @if ($std->year == $year->id) selected @endif>
                                {{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-around items-center">
                <div class="m-2 w-full">
                    <x-label value="ತಾಲೂಕು" />
                    <select name="taluk" id="taluk" class="w-full">
                        @foreach ($std->sub_districts as $sub_district)
                            <option value="{{ $sub_district->id }}"
                                @if ($std->sub_district == $sub_district->id) selected @endif>
                                {{ $sub_district->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2 w-full">
                    <x-label value="ಧರ್ಮ" />
                    <x-input type="text" value="{{ $std->religion }}" name="religion" id="religion" />
                </div>
                <div class="m-2 w-full">
                    <x-label value="ರಾಷ್ಟ್ರೀಯತೆ" />
                    <select name="nationaluty" id="nationaluty" class="w-full">
                        <option value="IN">Indian</option>
                    </select>
                </div>
            </div>

            <x-label value="ಹಿಂದಿನ ಶಾಲೆ" />
            <x-input type="text" value="{{ $std->prev_school }}" name="prevSchool" />
            <x-button-primary value="Save" />
        </div>
    </form>
</x-main-card>

<script>
    var inputs, index;

    inputs = document.getElementsByTagName('input');
    const nos = inputs.length
    for (index = 1; index <= nos; index++) {
        console.log(inputs[index]);
        enableTransliteration(inputs[index], 'kn')
    }

    enableTransliteration(document.getElementById('address'), 'kn')
</script>

<script>
    $("#editStd").select2();
    $("#class").select2();
    $("#city").select2();
    $('#states').select2();
    $('#district').select2();
    $('#taluk').select2();
    $('#caste').select2();
    $('#subc').select2();
    $('#cat').select2();
    $('#year').select2();

    $('#caste').on("select2:select", function(e) {
        let data = e.params.data;

    });

    $('#states').on("select2:select", function(e) {
        let data = e.params.data;

    });

    $('#district').on("select2:select", function(e) {
        let data = e.params.data;

    })

    function dist(id) {
        $.ajax({
            url: "{{ route('trans.getDistrict') }}",
            dataType: 'json',
            data: {
                id: id
            },
            success: function(data) {
                // dists = [{"id":1, "text":"sdfdsf"}];
                $("#district").html("")
                for (let i = 0; i < data.length; i++) {
                    $("#district").append(
                        `<option value="${data[i].id}"> ${data[i].text} </option>`
                    )
                }
            },
        });
    }

    function taluk(id) {
        $.ajax({
            url: "{{ route('trans.getTaluk') }}",
            dataType: 'json',
            data: {
                id: id
            },
            success: function(data) {
                $("#taluk").html("")
                for (let i = 0; i < data.length; i++) {
                    $("#taluk").append(
                        `<option value="${data[i].id}"> ${data[i].text} </option>`
                    )
                }
            },
        });
    }

    function cat(id) {
        $.ajax({
            url: "{{ route('trans.getCat') }}",
            dataType: 'json',
            data: {
                cast: id
            },
            success: function(res) {
                let data = res.cats;
                $("#cat").html("")
                for (let i = 0; i < data.length; i++) {
                    $("#cat").append(
                        `<option value="${data[i].cat}"> ${data[i].category.name} </option>`
                    )
                }


                let subs = res.subcasts;
                $("#subc").html("")
                for (let i = 0; i < subs.length; i++) {
                    $("#subc").append(
                        `<option value="${subs[i].id}"> ${subs[i].name} </option>`
                    )
                }
            },
        });
    }

    $('.numOnly').keypress(function(e) {

        var charCode = (e.which) ? e.which : event.keyCode
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which >
                57))
            return false;
    });
</script>
