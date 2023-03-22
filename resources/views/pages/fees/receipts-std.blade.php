<x-main-card>

    <b>{{ ucfirst($student->name) . ' ' . ucfirst($student->fname) . ' ' . ucfirst($student->lname) }}</b>ನ ರಸೀದಿಗಳು
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <x-table>
        <x-thead>
            <x-th>
                ರಶೀದಿ ಮೊತ್ತ
            </x-th>
            <x-th>
                ರಸೀದಿ ಸಂ
            </x-th>
            <x-th>
                ಶೈಕ್ಷಣಿಕ ವರ್ಷಕ್ಕೆ
            </x-th>
            <x-th>
                ತರಗತಿಗಾಗಿ
            </x-th>
            <x-th>
                ರಶೀದಿ ದಿನಾಂಕ
            </x-th>
            <x-th>

            </x-th>
        </x-thead>

        <tbody id="byId">
            @forelse($receipts as $receipt)
                <tr>
                    <x-td>
                        {{ $receipt->amt_paid }}
                    </x-td>
                    <x-td>
                        {{ $receipt->receipt_no }}
                    </x-td>
                    <x-td>
                        {{ $receipt->year }}
                    </x-td>
                    <x-td>
                        {{ $receipt->class }}
                    </x-td>
                    <x-td>
                        {{ $receipt->created_at->format('d-m-Y') }}
                    </x-td>
                    <x-td>
                        <a href="{{ route('fees.getDuplicate', ['id' => $receipt->id]) }}">
                            <x-button-primary value="get duplicate receipt" />
                        </a>
                    </x-td>
                </tr>
            @empty
                <tr>
                    <x-td colspan="">
                        ಯಾವುದೇ ರಸೀದಿಗಳು ಕಂಡುಬಂದಿಲ್ಲ
                    </x-td>
                </tr>
            @endforelse
        </tbody>
    </x-table>

</x-main-card>
