<x-main-card>
    Fees Details
    <div class="p-10 flex justify-evenly">
        <div class="flex flex-col">
            <label for="year" class="p-1">Academic Year</label>
            <select name="year" id="year">
                <option value="">Select Academic Year</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label for="class" class="p-1">Classes</label>
            <select name="class" id="class">
                <option value="">Select Class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

    </div>
    
    <div class="w-full flex justify-center">
        <div class="flex flex-col border w-1/4 rounded">
            
            <table>
                <thead class="bg-white border-b">
                    <tr>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Fee Description
                        </th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fees as $fee)
                        <tr id="r{{ $fee->id }}">
                            <td align="center">{{ $loop->iteration }}</td>
                            <td align="center">{{ $fee->desc }}</td>
                            <td align="center" id="btn{{ $fee->id }}">
                                <x-input type="text" name="desc_{{$loop->iteration}}" id="{{$fee->id}}"/>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t">
                        <td colspan="2" align="center">
                            Tuition Fee
                        </td>
                        <td>
                            <x-input type="text" name="tuition" id="tuition"/>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="p-2 flex justify-center loading">
                <button value="Save" onclick="saveDetails()" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight my-2
                uppercase rounded shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none 
               focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out">Save </button>
            </div>
        </div>
        
    </div>
</x-main-card>

<script>
    var descTable;
    $(document).ready(function () {
        descTable = $("#desc").html();
    });
    $("#year").select2();
    $("#class").select2();

    $("#year").on("select2:select", function(e){
        let data = e.params.data;
        getFeeDetails()
    });
    $("#class").on("select2:select", function(e){
        let data = e.params.data;
        getFeeDetails()
    });

    function getFeeDetails() {
        let year = $("#year").val();
        let clas = $("#class").val();
        if(year == "" || year == null || clas == '' || clas == null) return;
        $.ajax({
            type: "get",
            url: "{{route('master.getDetails')}}",
            data: {
                year: year,
                clas:clas
            },
            dataType: "json",
            
            success: function (res) {
               let amt = res.feeDetails;
                
                if(amt.length == 0) {
                    for(let i=01; i <= {{count($fees)}}; i++){
                        $(`input[name=desc_${i}]`).val("")
                    }
                    $("#tuition").val("")
                } else {
                    $("#tuition").val(amt[0].tuition)
                    for(let i=0; i<amt.length; i++){
                      $(`#${amt[i].fee_head}`).val(amt[i].amount);
                    }
                }
            }
        });
    }

    function saveDetails() {

        let year = $("#year").val();
        let clas = $("#class").val();
        let tut = $("#tuition").val();

        if(year == "" || year == null || clas == '' || clas == null) return;
        
        let amounts = [];

        for(let i=1; i <= {{count($fees)}}; i++ ) {
            amounts.push({id:$(`input[name='desc_${i}']`).attr("id"), amt: $(`input[name='desc_${i}']`).val()})
        }
        
        $.ajax({
            type: "post",
            url: "{{route('master.saveDetails')}}",
            data: {
                year: year,
                clas: clas,
                tut: tut,
                amounts: amounts 
            },
            dataType: "json",
            beforeSend: function (){
                $(".loading").html("")
                $(".loading").append(
                    `<x-loading-button name="Saving" />`
                )
            },
            success: function (response) {
                $(".loading").html("")
                $(".loading").append(
                    `<div class="flex space-x-2 items-center">
                        <button value="Save" onclick="saveDetails()" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight my-2
                        uppercase rounded shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none 
                    focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out">Save </button>
                    <svg xmlns="" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    </div>`
                )
                setTimeout(() => {
                    $(".loading svg").html("")
                }, 1500);
            }
        });

    }
</script>
