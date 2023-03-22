<x-main-card>
    ದಿನದ ಪುಸ್ತಕ
    <div class="w-full bg-gray-200" style="height: 1px;"></div> 
    <form action="{{route("general.getReceipt")}}" method="post">
        @csrf
    <div class="flex flex-col justify-center">
        <div class="w-1/3">
            <x-label value="ದಿನಾಂಕ ನಮೂದಿಸಿ"/>
            <x-input type="date" name="date" />
        </div>
        <x-button-primary value="ಸಲ್ಲಿಸು" class="w-1/3"/>
    </div>
</form>
</x-main-card>