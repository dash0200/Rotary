<x-main-card>
    ದಿನಾಂಕವಾರು
    <div class="w-full bg-gray-200" style="height: 1px;"></div> 

    <form action="{{route('general.datewiseGetReceipt')}}" method="post">
        @csrf
        <div class="flex justify-around">
            <div class="m-4">
                <x-label value="ದಿನಾಂಕದಿಂದ"/>
                <x-input type="date" name="from" required/>
            </div>
            <div class="m-4">
                <x-label value="ಇಲ್ಲಿಯವರೆಗೆ"/>
                <x-input type="date" name="to" required />
            </div>
            <div class="m-4">
                <x-label value="ಸಲ್ಲಿಸು"/>
                <x-button-primary value="ಸಲ್ಲಿಸು"/>
            </div>
        </div>
    </form>
</x-main-card>