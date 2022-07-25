<x-main-card>
    Fees Receipt
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="mt-5">
        <select name="student" id="stdsearh" class="w-full">
            <option value="">Start Typing [ STS - Register_No, Name Father_Name Last_Name, (date_od_admission) ]</option>
        </select>
    </div>
    <div class="flex m-9">
        <div class="w-full">
            <div class="flex justify-between border-2 p-1">
                <div>
                    <x-label value="Admission Type" />
                    <x-input type="text" name="stdtype" id="admType" placeholder="Admission Type" readonly />
                </div>
                <div>
                    <x-label value="Standard" />
                    <x-input type="text" name="standard" placeholder="Standard" readonly />
                </div>
            </div>
           <div class="border-2 p-1">
             <div class="mb-2">
                 <x-label value="Student Name" />
                 <x-input type="text" name="name" placeholder="Student Name" readonly />
             </div>
             <div class="mb-2">
                 <x-label value="Father Name" />
                 <x-input type="text" name="fname" placeholder="Father Name" readonly />
             </div>
           </div>
            <div class="flex justify-between border-2 p-1">
                <div>
                    <x-label value="Receipt Date" />
                    <x-input type="date" value="{{ date('Y-m-d') }}" name="rdate" placeholder="Receipt Date" />
                </div>
                <div>
                    <x-label value="Financial Year" />
                    <x-input type="text" name="fyear" placeholder="Financial Year" />
                </div>
            </div>

            <div class="flex justify-between space-x-2 border-2 p-1">

                <div>
                    <x-label value="Annual Fee" />
                    <x-input type="text" name="annualFee" placeholder="Annual Fee" />
                </div>
                <div>
                    <x-label value="Fees Paid" />
                    <x-input type="text" name="feesPaid" placeholder="Fees Paid" />
                </div>
                <div>
                    <x-label value="Balance" />
                    <x-input type="text" name="balanceFee" placeholder="Balance Fee" />
                </div>

            </div>
        </div>


        <div class="w-full px-5">

        </div>
    </div>
</x-main-card>

<script>
   
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
        let data = e.params.data;
        
        $.ajax({
            type: "get",
            url: "{{route('getstudent')}}",
            data: {
                id: data.id
            },
            dataType: "json",
            success: function (res) {
                parseInt
                if(parseInt(res.doy) == new Date().getFullYear()) {
                    $("#admType").val("NEW")
                } else {
                    $("#admType").val("OLD")
                }
                
            }
        });
    })
</script>
