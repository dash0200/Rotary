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
            <div class="flex justify-center items-center bg-violet-200 p-2">
                <h5>Fees Description</h5>
            </div>

            <div class="p-2">
                <table class="w-full" id="desc">
                    @foreach ($fees as $fee)
                        <tr id="r{{ $fee->id }}">
                            <td align="center">{{ $loop->iteration }}</td>
                            <td align="center">{{ $fee->desc }}</td>
                            <td align="center" id="btn{{ $fee->id }}">
                                <button onclick="moveRow('{{ $fee->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="flex flex-col border w-1/4 rounded">
            <div class="flex justify-center items-center bg-violet-200 p-2">
                <h5>Fee Details for <span class="text-blue-500"><span id="cls">-</span> <span id="yr">-</span></span>  </h5>
            </div>

            <div class="p-2">
                <table class="w-full" id="feeDetails">

                </table>
            </div>
            <div class="w-full h-full flex flex-col justify-end px-2 load">
                <button onclick="submit()"
                    class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight my-2
                        uppercase rounded shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none 
                    focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out">
                    Save
                </button>
            </div>
            
        </div>
        <div id="right">
          
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
        $("#yr").text("("+data.text+")");
        getFeeDetails()
    });
    $("#class").on("select2:select", function(e){
        let data = e.params.data;
        $("#cls").text("("+data.text+")");
        getFeeDetails()
    });

    function moveRow(id) {

        let trCode = $("#r" + id).html();
        $("#feeDetails").append(
            ` <tr id="mvr${id}" >
                ${trCode}
            </tr>`
        );

        setTimeout(() => {
            $("#btn" + id).html("");
            $("#btn" + id).append(`
                <button onclick="moveBack(${id})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </button>
                `);
        }, 10);

        $("#r" + id).remove("");
    }


    function moveBack(id) {
        let code = $("#mvr" + id).html();
        $("#desc").append(`
        <tr id="r${id}">
        ${code}
        </tr>`);

        var id = id;
        setTimeout(() => {
            $("#btn" + id).html("");
            $("#btn" + id).append(`
        <button onclick="moveRow(${id})">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
        `);
        }, 10);
        $("#mvr" + id).remove()
    }

    function submit() {
        var arr = [];
        let year = $("#year").val();
        let cls = $("#class").val();
        $("#feeDetails tr").each(function() {
            arr.push(this.id.replace("mvr", ""));
        });

        if(year == null || year == "") {
            alert('Please Select Academic Year')
            return;
        }

        if(cls == null || cls == "") {
            alert('Please Select Class')
            return;
        }

        if(arr.length !== 0) {
            Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "{{route('master.saveDetails')}}",
                    data: {
                        year: year,
                        clas: cls,
                        fees: arr
                    },
                    dataType: "json",
                    beforeSend: function(){
                        $(".load").html("");
                        $(".load").append(`<x-loading-button class=""/>`);
                    },
                    success: function (response) {
                        $(".load").html("");
                        $(".load").append(`<button onclick="submit()"
                            class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight my-2
                                uppercase rounded shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none 
                            focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out">
                            Save
                        </button>`);
                        $("#right").append(`  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>`);

                        setTimeout(() => {
                            $("#right").html("");
                        }, 1500);
                    }
                });
            }
        })
        }

    }

    function getFeeDetails() {
        let year = $("#year").val();
        let clas = $("#class").val();

        if(year == null || year == "" || clas == null || clas == "") return;

            $.ajax({
                type: "get",
                url: "{{route('master.getDetails')}}",
                data:  {
                    year: year,
                    clas: clas
                },
                dataType: "json",
                success: function (res) {
                    let desc = res.feeDetails;
                    console.log(desc);
                    $("#feeDetails").html("");
                    $("#desc").html("");
                    $("#desc").append(`${descTable}`);
                    for(let i=0; i<desc.length; i++) {

                        moveRow(desc[i].fee_head);
                        $("#btn" + desc[i].fee_head).remove();
                        // $("#feeDetails").append(`
                        // <tr id="r${desc[i].fee_head}">
                        //     <td align="center">${desc[i].fee_head.desc}</td>
                        // </tr>`);
                    }

                }
            });
        }
</script>
