<header>
    <style>
        label.error {
            color: #ff514dca;
            border-color: #ebccd1;
        }

    </style>
</header>
<x-main-card>
    <div class="">Fees Head</div>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="p-10">
        <div class="flex justify-between">
            <div class="w-1/2">
                <form id="fees" method="GET">
                    <div class="relative w-1/2 mb-6 group">
                        <x-label value="Fee Description" for="name" />
                        <div class="flex items-center">
                            <div class="flex-col">
                                <x-input type="text" name="description" id="description" />
                            </div>
                            <span id="stat"></span>
                        </div>
                    </div>
                    <span id="load">
                        <x-button-primary value="Save" type="reset"/>
                    </span>
                </form>
            </div>

            <div>

                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    SL No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="px-6 py-4 font-medium">
                                    1
                                </td>
                                <td class="px-6 py-4">
                                    asd
                                </td>
                                <td class="px-6 py-4">
                                    asd
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-main-card>



<script>
    $(document).ready(function() {

        $('#description').keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

        getFeeDescription();

        $('#fees').validate({
            rules: {
                slno: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true,
                    minlength: 2
                }
            },
        });

    });

    function getFeeDescription() {

        $.ajax({
            type: "get",
            url: "{{ route('master.getFeeDescription') }}",
            dataType: "json",
            beforeSend: function(){
                $('tbody').html('');
                    $('tbody').append(
                        `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="3" align="center" class="px-6 py-4 font-medium">
                                <svg role="status" class="inline w-6 h-6 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                            </td>
                        </tr>`
                    );
            },
            success: function(response) {
                let desc = response.desc;

                if(desc.length !== 0) {
                    $('tbody').html('');
                    for(let i=0; i <  desc.length; i++) {
                        $('tbody').append(
                        `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td class="px-6 py-4 font-medium">
                                ${i+1}
                            </td>
                            <td class="px-6 py-4">
                                ${desc[i].description}
                            </td>
                            <td class="px-6 py-4">
                                edit
                            </td>
                            </tr>`
                    );
                    }
                } else {
                    $('tbody').html('');
                    $('tbody').append(
                        `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="3" align="center" class="px-6 py-4 font-medium">
                                No Data Found
                            </td>
                        </tr>`
                    );
                }
            }
        });
    }

    

    $('#fees').submit(function(e) {
        e.preventDefault();

        $('#fees').validate({
            rules: {
                slno: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true,
                    minlength: 2
                }
            }
        });

        if ($('#fees').valid()) {

            $.ajax({
                type: "post",
                url: "{{ route('master.saveFeeDescription') }}",
                data: {
                    slno: $('#slno').val(),
                    description: $('#description').val()
                },
                beforeSend: function() {
                    $('#load').html('');
                    $('#load').append(
                        `
                        <x-button-loading value="Saving" />
                        `
                    );
                },
                dataType: "json",
                success: function(response) {
                    $('#load').html('');
                    $('#load').append(
                        `
                        <x-button-primary value="Save"/>
                        `
                    );

                    $('#stat').html('');
                    $('#stat').append(
                        `<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                        </svg>`
                    );
                    setTimeout(() => {
                        $('#stat').html('');
                    }, 2500);

                    getFeeDescription();

                },
                error: function () {
                    $('#stat').html('');
                    $('#stat').append(
                        `<svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>`
                    );

                    setTimeout(() => {
                        $('#stat').html('');
                    }, 2500);

                    $('#load').html('');
                    $('#load').append(
                        `
                        <x-button-primary value="Save"/>
                        `
                    );
                }
            });
        }

    });
</script>
