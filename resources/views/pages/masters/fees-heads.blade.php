<x-main-card>
    <div class="">Fees Head</div>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>
    <div class="p-10 flex justify-around">
        <form class="w-full">
            <div class="relative z-0 w-1/4 mb-6 group">
                <x-label value="Name" for="name"/>
                <x-input type="text" name="name" id="name"/>
            </div>
           <div class="loading">
                <x-button-primary value="Save" />
           </div>
        </form>
        <div class="flex flex-col w-full">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table>
                            <thead class="bg-white border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        #
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Fee Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        Mark
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-main-card>

<script>
    
    $("form").submit(function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "post",
            url: "{{route('master.saveFeesDesc')}}",
            data: {
                desc: $("#name").val()
            },
            dataType: "json",
            beforeSend: function () {
                $(".loading").html("")
                $(".loading").append(
                    `<x-loading-button name="Saving" />`
                )
            },
            success: function (response) {
                $(".loading").html("")
                $(".loading").append(
                    `
                    <div class="flex space-x-2 items-center">
                        <x-button-primary value="Save" />
                    <svg xmlns="" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    </div>
                    `
                )
            }
        });
    });

</script>