<x-main-card>
    <div class="d-flex justify-content-end" style="width:100%">
        <select name="editStd" id="stdsearh" style="width:40%">
            <option value="">Search Student</option>
        </select>
    </div>
    New Admission
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <form action="{{ route('trans.saveAdmission') }}">
        <div class="flex flex-col">
            <div class="flex space-x-3 w-full justify-around">
                <div class="flex flex-col">
                    <div class="m-2">
                        <x-label value="STS" />
                        <x-input type="text" name="sts" placeholder="SST" />
                    </div>
                    <div class="m-2">
                        <x-label value="Admission Date" />
                        <x-input type="date" name="admDate"
                            class="{{ $errors->has('admDate') ? 'is-invalid' : '' }}" required
                            value="{{ date('Y-m-d') }}" placeholder="Pick Date" />
                    </div>
                    <div class="m-2">
                        <x-label value="Classes" />
                        <select name="class" id="class" required
                            class="{{ $errors->has('class') ? 'is-invalid' : '' }}">
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="m-2">
                        <x-label value="Student Name" />
                        <x-input type="text" placeholder="First Name"
                            class="{{ $errors->has('fname') ? 'is-invalid' : '' }}" name="fname" required
                            class="alphaonly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Father Name" />
                        <x-input type="text" placeholder="Father Name" name="father" class="alphaonly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Mother Name" />
                        <x-input type="text" placeholder="Mother Name" name="mname" class="alphaonly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Sur Name" />
                        <x-input type="text" placeholder="Sur Name" name="surname" class="alphaonly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Address" />
                        <textarea class="resize rounded-md" id="address" name="address" required></textarea>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="m-2">
                        <x-label value="City" />
                        <select name="city" id="city" required>
                            <option value="">Select City</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="m-2">
                        <x-label value="Phone Number" />
                        <x-input type="text" placeholder="Phone" name="phone" class="numOnly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Mobile Number" />
                        <x-input type="text" placeholder="Mobile" name="mobile" class="numOnly" />
                    </div>
                    <div class="m-2">
                        <x-label value="Date of Birth" />
                        <x-input type="date" placeholder="DOB" name="dob" required
                            max="{{ date('Y-m-d') }}" />
                    </div>
                </div>
            </div>

            <div class="flex justify-around space-x-3">
                <div class="flex flex-col">
                    <div class="m-2">
                        <x-label value="Birth Place" />
                        <x-input type="text" placeholder="Birth Place" name="birthPlace" class="alphaonly" />
                    </div>
                    <div class="m-2">
                        <x-label value="State" />
                        <select name="states" id="states" class="w-full">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{$state->id}}">
                                    {{ $state->name }}</option>
                            @endforeach
                        </select>
                        <input id="slectedState" type="text" hidden />
                    </div>
                    <div class="m-2">
                        <x-label value="District" />
                        <select name="district" id="district" class="w-full"> </select>
                    </div>
                    <div class="m-2">
                        <x-label value="Taluk" />
                        <select name="taluk" id="taluk" class="w-full"> </select>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="m-2">
                        <x-label value="Caste" />
                        <select name="caste" id="caste" class="w-full" required>
                            <option value="">Select Caste</option>
                            @foreach ($castes as $caste)
                                <option value="{{ $caste->id }}">{{ $caste->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="m-2 ">
                        <x-label value="Sub Caste" />
                        <select name="subc" id="subc" class="w-full"></select>
                    </div>
                    <div class="m-2">
                        <x-label value="cat" />
                        <select name="cat" id="cat" class="w-full">
                            <option value="">Select Cat</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <x-label value="Religion" />
                        <x-input type="text" name="religion" id="religion" />
                    </div>
                    <div class="m-2">
                        <x-label value="nationaluty" />
                        <select name="nationaluty" id="nationaluty" class="w-full">
                            <option value="IN">Indian</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col ll">
                    <div class="m-2">
                        <x-label value="Gender" />
                        <div class="flex justify-center">
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        value="1" type="radio" checked name="gender" id="male">
                                    <label class="form-check-label inline-block text-gray-800" for="male">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        value="0" type="radio" name="gender" id="female">
                                    <label class="form-check-label inline-block text-gray-800" for="female">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-2">
                        <x-label value="Handicap ?" />
                        <div class="flex justify-center">
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        value="0" type="radio" checked name="handicap" id="no">
                                    <label class="form-check-label inline-block text-gray-800" for="no">
                                        No
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        value="1" type="radio" name="handicap" id="yes">
                                    <label class="form-check-label inline-block text-gray-800" for="yes">
                                        Yes
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="m-2">
                            <x-label value="Year" />
                            <select name="ac_year" id="year" class="w-full" required>
                                <option value="">Academic Year</option>
                                @foreach ($years as $year)
                                    <option value="{{$year->id}}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <x-label value="Previous School" />
            <x-input type="text" name="prevSchool" />

            <input type="text" name="id" id="id" hidden>
            <x-button-primary value="Save" />
        </div>

    </form>
</x-main-card>

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

    $("#stdsearh").select2({
        ajax: { 
        url: "{{route('getStdId')}}",
        type: "get",
        dataType: 'json',
        data: function (params) {
            return {
            term: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
        }
    });
    $("#stdsearh").on("select2:select", function(e){
        let id = e.params.data.id;

        $.ajax({
            type: "get",
            url: "{{route('getAdmStd')}}",
            data: {
                id: id
            },
            dataType: "json",
            success: function (res) {
                console.log(res);
                $("input[name=sts]").val(res.sts)
                $("input[name=admDate]").val(res.doy)
                $("#class").select2("val", `${res.class}`);
                $("input[name=fname]").val(res.name)
                $("input[name=father]").val(res.fname)
                $("input[name=mname]").val(res.mname)
                $("input[name=surname]").val(res.lname)
                $("textarea#address").val(res.address)
                $("#city").select2("val", `${res.city}`);
                $("input[name=phone]").val(res.phone)
                $("input[name=mobile]").val(res.mobile)
                $("input[name=dob]").val(res.dobf)
                $("input[name=birthPlace]").val(res.birth_place)
                $("#states").select2("val", `${res.district.state.state}`);
                dist(res.district.district)
                $("#district").select2("val", `${res.district.district}`);
                taluk(res.district.district)
                $("#taluk").select2("val", `${res.sub_district}`);
                $("#caste").select2("val", `${res.caste}`);
                $("#religion").val(`${res.religion}`);
                cat(res.caste)
                $("#subc").select2("val", `${res.sub_caste}`);
                $("#cat").select2("val", `${res.category}`);
                if(res.gender == 1) {
                    $("#male").prop("checked", true)
                } else {
                    $("#female").prop("checked", true)
                }
                if(res.handicap == 0) {
                    $("#no").prop("checked", true)
                } else {
                    $("#yes").prop("checked", true)
                }
                
                $("#year").select2("val", `${res.year}`);
                $("input[name=prevSchool]").val(res.prev_school)
                $("#id").val(res.id)
            }  
        });
    }); 

    $('#caste').on("select2:select", function(e) {
        let data = e.params.data;
        cat(data.id)
    });

    $('#states').on("select2:select", function(e) {
        let data = e.params.data;
        dist(data.id)
    });

    $('#district').on("select2:select", function(e) {
        let data = e.params.data;
        taluk(data.id)
    })

    $(document).ready(function() {
        dist(11)
        taluk(1)
    });

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

    $('.alphaonly').bind('keyup blur', function() {
        var node = $(this);
        node.val(node.val().replace(/[^aA-zZ]/g, ''));
    });
</script>
