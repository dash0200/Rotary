<x-main-card>
    <div>
        <x-table>
            <x-thead>
                <x-th>
                    Register No
                 </x-th>
                 <x-th>
                    STS
                 </x-th>
                <x-th>
                    Name
                </x-th>
                <x-th>
                   Father Name
                </x-th>
                <x-th>
                    Mother Name
                 </x-th>
                 <x-th>
                    Surname
                 </x-th>
                 <x-th>
                    DOB
                 </x-th>
            </x-thead>
            <tbody id="adm">
                
            </tbody>
        </x-table>  
    </div>


    <div>
        Last Class & Academic Year
        <x-table>
            <x-thead>
                <x-th>
                   Class
                 </x-th>
                 <x-th>
                    Academic Year
                 </x-th>
            </x-thead>
            <tbody id="lastCls">
                
            </tbody>
        </x-table>  
    </div>
    Leaving Certificate
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="flex flex-col space-y-4">
        <div class="flex space-x-2 mt-5 items-center justify-between">
            <div>
                <x-label value="Register Number" />
                <select name="student" id="stdsearh" class="w-full">
                    <option value="">Start Typing [ STS - Register_No, Name Father_Name Last_Name, (date_of_admission) ]</option>
                </select>
            </div>
            <div>
                <x-label value="Studied Till Class" />
                <select name="class" id="class" >
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-label value="Till Academic Year" />
                <select name="year" id="year">
                    <option value="">Select Year</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-between mt-5 space-x-2">
            <div class="w-full">
                <x-label value="WAS STUDYING WHILE LEAVING" />
                <x-input name="wasStd" placeholder="WAS STUDYING WHILE LEAVING" />
            </div>
            <div class="w-full">
                <x-label value="WHETHER QUALIFIED FOR PROMOTION" />
                <x-input name="wasStd" placeholder="WHETHER QUALIFIED FOR PROMOTION" />
            </div>
        </div>
        
        <div class="flex justify-between mt-5 space-x-2">
            <div class="w-full">
                <x-label value="LAST ATTENDANCE" />
                <x-input type="date" name="la" />
            </div>
            <div class="w-full">
                <x-label value="DATE OF APPLICATION" />
                <x-input type="date" name="dop" />
            </div>
            <div class="w-full">
                <x-label value="DATE OF ISSUING L.C" />
                <x-input type="date" name="doi" />
            </div>
            <div class="w-full">
                <x-label value="REASONING for Leaving the School" />
                <x-input type="text" name="reason" />
            </div>
        </div>

        <div class="flex justify-between mt-5 space-x-2">
            <div>
                <x-label value="ADMITTED TO CLASS" />
                <x-input type="text" name="atc" />
            </div>

            <div>
                <x-label value="ADMITTED YEAR" />
                <x-input type="text" name="ay" />
            </div>

            <div>
                <x-label value="DATE OF ADMISSION" />
                <x-input type="text" name="doa" />
            </div>

            <div>
                <x-label value="STUDYING IN" />
                <x-input type="text" name="stdin" />
            </div>

            <div>
                <x-label value="CURRENT YEAR" />
                <x-input type="text" name="cy" />
            </div>
        </div>

        <div class="flex mt-5 justify-between space-x-2">

            <div>
                <x-label value="Student Name" />
                <x-input type="text" id="name" />
            </div>

            <div>
                <x-label value="Father Name" />
                <x-input type="text" id="father" />
            </div>

            <div>
                <x-label value="MOTHER NAME" />
                <x-input type="text" id="mother" />
            </div>

            <div>
                <x-label value="SUR NAME" />
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

    function submitLC(id) {
        
    }
    
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
    })

    $("#stdsearh").on("select2:select", function(e){
        let data = e.params.data;
        $.ajax({
            type: "get",
            url: "{{route('trans.getStuddent')}}",
            data: {
                id: data.id
            },
            dataType: "json",
            success: function (res) {
                console.log(res);
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
                            ${res[1].std.name}
                        </x-td>

                        <x-td>
                            ${res[1].aca_year.year}
                        </x-td>
                    </x-body-tr>
                    `
                )

                $("#save").append(
                    `
                    <x-button-primary class="w-1/4" value="SUBMIT" onclick="submitLC(${res[0].id})" />
                    `
                )
            }
        });
    })


</script>