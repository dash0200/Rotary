<x-main-card>
    Update Receipt - ({{ $student }}) - {{ $id }} <br>
    <span>{{ $detail }}</span>
    <div class="w-full flex justify-around bg-gray-200" style="height: 1px;"></div>

    @foreach ($receipts as $re)
       <div class="border rounded p-4">
        <form action="{{ route('fees.feeUpdate') }}" method="POST">
            @csrf
            <div class="mt-3">
                <label for="" class="mt-2">Receipt No</label>
                <x-input type="text" name="id" value="{{ $re->id }}" readonly />
            </div>

            <div class="mt-3">
                <label for="" class="mt-2">Amount</label>
                <x-input type="text" name="amount" value="{{ $re->amt_paid }}" />
            </div>

            <x-button-primary>update</x-button-primary>
        </form>
       </div>

    <div class="w-full flex justify-around bg-gray-200 mt-10" style="height: 1px;"></div>
    @endforeach
</x-main-card>