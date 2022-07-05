<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                Creating Classes
                <div class="w-full bg-gray-200" style="height: 1px;"></div>

                <div class="flex flex-col">
                    <div class="flex space-x-3 w-full justify-around">
                        <div class="m-2">
                            <x-label value="Admission Date" />
                            <select name="year" id="year">
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="m-2">
                            <x-label value="Classes" />
                            <select name="class" id="class">
                                <option value="">Select Year</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="m-2">
                            <x-label value="Total Amount" />
                            <input type="text" disabled id="amt">
                        </div>
                    </div>
                </div>

                <x-table>

                    <x-thead>
                        <x-th>
                            #
                        </x-th>
                        <x-th>
                            Student Name
                        </x-th>
                        <x-th>
                            Sur Name
                        </x-th>
                        <x-th>
                            Previous Class
                        </x-th>
                        <x-th>
                            Academic Year
                        </x-th>
                        <x-th>
                            Action
                        </x-th>
                    </x-thead>

                    <tbody id="creating">

                    </tbody>

                </x-table>
                <div class="flex justify-center">
                    <x-button-primary value="Save" onclick="createClass()" />
                </div>
                <x-table>
                    <h2>Already Added Students</h2>
                    <x-thead>
                        <x-th>
                            #
                        </x-th>
                        <x-th>
                            Student Name
                        </x-th>
                        <x-th>
                            Sur Name
                        </x-th>
                        <x-th>
                            Academic Year
                        </x-th>
                    </x-thead>

                    <tbody id="added">

                    </tbody>

                </x-table>
               
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <h1 class="text-xl flex justify-center text-violet-600">Newly Admitted Students</h1>
            <div class="flex">
                <div class="mb-3 xl:w-96">
                  <div class="input-group relative flex flex-wrap items-stretch w-full mb-4 rounded">
                    <input type="search" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           id="search" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                  </div>
                </div>
              </div>
            <x-table>

                <x-thead>
                    <x-th>
                        #
                    </x-th>
                    <x-th>
                        Student Name
                    </x-th>
                    <x-th>
                        Sur Name
                    </x-th>
                    <x-th>
                        Current Class
                    </x-th>
                    <x-th>
                        Academic Year
                    </x-th>
                    <x-th>
                        Action
                    </x-th>
                </x-thead>

                <tbody id="newstd">

                </tbody>

            </x-table>
        </div>
    </div>
    <div class="max-w-7xl mx-auto my-8 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <h1 class="text-xl flex justify-center text-orange-600">Previous Class Students</h1>
            <div class="flex">
                <div class="mb-3 xl:w-96">
                  <div class="input-group relative flex flex-wrap items-stretch w-full mb-4 rounded">
                    <input type="search" class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           id="searchPrev" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                  </div>
                </div>
              </div>
            <x-table>

                <x-thead>
                    <x-th>
                        #
                    </x-th>
                    <x-th>
                        Student Name
                    </x-th>
                    <x-th>
                        Sur Name
                    </x-th>
                    <x-th>
                        Current Class
                    </x-th>
                    <x-th>
                        Academic Year
                    </x-th>
                    <x-th>
                        Action
                    </x-th>
                </x-thead>

                <tbody id="current">

                </tbody>

            </x-table>
        </div>
    </div>
</x-app-layout>

<script>
    $('#year').select2();
    $('#class').select2();

    $('#year').on("select2:select", function(e) {
        getStudents()
    });
    $('#class').on("select2:select", function(e) {
        getStudents()
    });

    function getStudents() {
        let year = $('#year').val();
        let clas = $('#class').val();
        if (year == "" || year == null || clas == '' || clas == null) return;

        $.ajax({
            type: "get",
            url: "{{ route('trans.getCurrentClass') }}",
            data: {
                year: year,
                clas: clas
            },
            dataType: "json",
            success: function(res) {
                let added = res.addedStd;
                $("#amt").val(res.totalAmt.toFixed(2))
                let news = res.new;
                console.log(news);
                let prevs = res.old;
                $("#newstd").html("");
                for (let i = 0; i < news.length; i++) {
                    $("#newstd").append(
                        `<x-body-tr id="trN_${news[i].id}" class="${news[i].id}">
                        <x-td-num>
                            ${news[i].id}
                        </x-td-num>
                        <x-td>
                            ${news[i].name}
                        </x-td>
                        <x-td>
                            ${news[i].lname}
                        </x-td>
                        <x-td>
                            new
                        </x-td>
                        <x-td>
                           2022-23
                        </x-td>
                        <x-td id="btn${news[i].id}">
                          <button onclick="moveRow(${news[i].id})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                              </svg>
                          </button>
                        </x-td>
                    </x-body-tr>`
                    )
                }

                $("#current").html("");
                for (let i = 0; i < prevs.length; i++) {
                    // removeAdmit(prevs[i].get_student.id)
                    $("#current").append(
                        `<x-body-tr id="trPre_${prevs[i].get_student.id}">
                        <x-td-num id="${prevs[i].get_student.id}">
                            ${prevs[i].get_student.id}
                        </x-td-num>
                        <x-td>
                            ${prevs[i].get_student.name}
                        </x-td>
                        <x-td>
                            ${prevs[i].get_student.lname}
                        </x-td>
                        <x-td>
                            ${prevs[i].standard_class.name}
                        </x-td>
                        <x-td>
                            ${prevs[i].aca_year.year}
                        </x-td>
                        <x-td id="btnP${prevs[i].get_student.id}">
                          <button onclick="movePrevRow(${prevs[i].get_student.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                              </svg>
                          </button>
                        </x-td>
                    </x-body-tr>`
                    )

                    removeAdmit(`#trN_${prevs[i].get_student.id}`)
                    
                }

                $("#added").html("");
                for (let i = 0; i < added.length; i++) {
                   
                    $("#added").append(
                        `<x-body-tr id="tr_${added[i].get_student.id}" class="${added[i].get_student.id}">
                        <x-td-num>
                            ${added[i].get_student.id}
                        </x-td-num>
                        <x-td>
                            ${added[i].get_student.name}
                        </x-td>
                        <x-td>
                            ${added[i].get_student.lname}
                        </x-td>
                        
                        <x-td>
                           2022-23
                        </x-td>
                        
                    </x-body-tr>`
                    )
                     removeAdmit(`#trN_${added[i].get_student.id}`)
                     removeAdmit(`#trPre_${added[i].get_student.id}`)
                }
            }
        });
    }

    function moveRow(id) {
        let trCode = $("#trN_" + id).prop('outerHTML');

        $("#trN_" + id).remove("");
        $("#creating").append(`${trCode}`)

        $(`#btn${id}`).html("")
        $("#btn" + id).append(`
        <button onclick="moveBack(${id})">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </button>`)


    }

    function movePrevRow(id) {
        let trCode = $("#trPre_" + id).prop('outerHTML');

        $("#trPre_" + id).remove("");
        $("#creating").append(`${trCode}`)

        $(`#btnP${id}`).html("")
        $("#btnP" + id).append(`
        <button onclick="movePrevBack(${id})">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </button>`)


    }

    function movePrevBack(id) {
        let trCode = $("#trPre_" + id).prop('outerHTML');

        $("#trPre_" + id).remove("");
        $("#current").append(`${trCode}`)


        $(`#btnP${id}`).html("")
        $("#btnP" + id).append(`
        <button onclick="movePrevRow(${id})">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                              </svg>
        </button>`)

    }

    function moveBack(id) {
        let trCode = $("#trN_" + id).prop('outerHTML');

        $("#trN_" + id).remove("");
        $("#newstd").append(`${trCode}`)

        $(`#btn${id}`).html("")
        $("#btn" + id).append(`
            <button onclick="moveRow(${id})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
            </button>`)
    }


    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#newstd tr_").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#searchPrev").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#current tr_").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    
    function createClass() {

        let year = $("#year").val();
        let clas = $("#class").val();
        let amt = $("#amt").val();
        if(amt == "" || amt == null) {
            alert("Total Amount cannot be empty")
            return;
        }
        if (year == "" || year == null || clas == '' || clas == null) return;
        
        let ids = [];
        $("#creating > tr").each(function() {
            ids.push(
                {id: $(this).attr("id").split("_")[1]}
            )
        });

        if(ids.length < 1) return;
        
        $.ajax({
            type: "post",
            url: "{{route('trans.createClass')}}",
            data: {
                stds: ids,
                year: year,
                clas: clas,
                amt: amt
            },
            dataType: "json",
            success: function (res) {
                
            }
        });
    }

    function removeAdmit(id) {
        $(id).remove();
    }

</script>
