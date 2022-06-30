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

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
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
                let news = res.new;

                for (let i = 0; i < news.length; i++) {
                    $("#current").append(
                        `<x-body-tr id="tr${news[i].id}">
                        <x-td-num>
                            ${i+1}
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
            }
        });
    }

    function moveRow(id) {
        let trCode = $("#tr" + id).prop('outerHTML');

        $("#tr" + id).remove("");
        $("#creating").append(`${trCode}`)

        $(`#btn${id}`).html("")
        $("#btn" + id).append(`
        <button onclick="moveBack(${id})">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </button>`)


    }

    function moveBack(id) {
        let trCode = $("#tr" + id).prop('outerHTML');

        $("#tr" + id).remove("");
        $("#current").append(`${trCode}`)

        $(`#btn${id}`).html("")
        $("#btn" + id).append(`
            <button onclick="moveRow(${id})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                              </svg>
            </button>`)
    }
</script>
