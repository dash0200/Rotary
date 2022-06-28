<x-main-card>
    New Admission
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex flex-col">
        <div class="flex space-x-3 w-full justify-around">
            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="SST" />
                    <x-input type="text" name="sst" placeholder="SST" />
                </div>
                <div class="m-2">
                    <x-label value="Admission Date" />
                    <x-input type="date" name="admDate" placeholder="Pick Date" />
                </div>
                <div class="m-2">
                    <x-label value="Classes" />
                    <select name="class" id="class">
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
                    <x-input type="text" placeholder="First Name" required />
                </div>
                <div class="m-2">
                    <x-label value="Father Name" />
                    <x-input type="text" placeholder="Father Name" />
                </div>
                <div class="m-2">
                    <x-label value="Mother Name" />
                    <x-input type="text" placeholder="Mother Name" />
                </div>
                <div class="m-2">
                    <x-label value="Sur Name" />
                    <x-input type="text" placeholder="Sur Name" />
                </div>
                <div class="m-2">
                    <x-label value="Address" />
                    <textarea class="resize rounded-md" name="address"></textarea>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="City" />
                    <select name="city" id="city">
                        <option value="">Select Class</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2">
                    <x-label value="Phone Number" />
                    <x-input type="text" placeholder="Phone" />
                </div>
                <div class="m-2">
                    <x-label value="Mobile Number" />
                    <x-input type="text" placeholder="Mobile" />
                </div>
                <div class="m-2">
                    <x-label value="Date of Birth" />
                    <x-input type="date" placeholder="DOB" max="{{ date('Y-m-d') }}" />
                </div>
            </div>
        </div>

        <div class="flex space-x-3">
            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="Birth Place" />
                    <x-input type="text" placeholder="Birth Place" />
                </div>
                <div class="m-2">
                    <x-label value="State" />
                    <select name="states" id="states" class="w-full">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
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
                    <select name="caste" id="caste">
                        <option value="">Select Caste</option>
                        @foreach ($castes as $caste)
                            <option value="{{ $caste->id }}">{{ $caste->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2">
                    <x-label value="Sub Caste" />
                    <select name="subc" id="subc"></select>
                </div>
                <div class="m-2">
                    <x-label value="cat" />
                    <select name="cat" id="cat">
                        <option value="">Select Cat</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col ll">

            </div>
        </div>
    </div>

</x-main-card>

<script>
    $("#class").select2();
    $("#city").select2();
    $('#states').select2();
    $('#district').select2();
    $('#taluk').select2();
    $('#caste').select2();
    $('#subc').select2();
    $('#cat').select2();

    $('#caste').on("select2:select", function(e) {
        let data = e.params.data;
        cat(data.text)
    });

    $('#states').on("select2:select", function(e) {
        let data = e.params.data;
        dist(data.id)
    });

    $('#district').on("select2:select", function(e) {
        let data = e.params.data;
        taluk(data.id)
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
                        `<option value=" ${data[i].id}"> ${data[i].text} </option>`
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
                        `<option value=" ${data[i].id}"> ${data[i].text} </option>`
                    )
                }
            },
        });
    }

    function cat(cast) {
        $.ajax({
            url: "{{ route('trans.getCat') }}",
            dataType: 'json',
            data: {
                cast: cast
            },
            success: function(data) {
                $("#cat").html("")
                for (let i = 0; i < data.length; i++) {
                    $("#cat").append(
                        `<option value=" ${data[i].cat}"> ${data[i].text} </option>`
                    )
                }
            },
        });
    }

   
</script>
