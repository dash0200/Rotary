<x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ __('ಡ್ಯಾಶ್‌ಬೋರ್ಡ್') }}
</x-jet-nav-link>

<x-drop :name="'ಮಾಸ್ಟರ್'" :active="request()->routeIs('master.*')">
    <x-dropdown-link href="{{ route('master.feesHeads') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('master.feesHeads')">
        ಶುಲ್ಕದ ಮುಖ್ಯಸ್ಥರು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('master.feesDetails') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('master.feesDetails')">
        ಶುಲ್ಕದ ವಿವರಗಳು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('master.castDetails') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('master.castDetails')">
        ಪಾತ್ರವರ್ಗದ ವಿವರಗಳು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('master.states') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('master.states')">
        ರಾಜ್ಯ-ಜಿಲ್ಲೆ-ತಾಲ್
    </x-dropdown-link>
</x-drop>

<x-drop :name="'ವಹಿವಾಟುಗಳು'" :active="request()->routeIs('trans.*')">
    <x-dropdown-link href="{{ route('trans.newAdmission') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('trans.newAdmission')">
        ಹೊಸ ಪ್ರವೇಶ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('trans.creatingClasses') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('trans.creatingClasses')">
        ತರಗತಿಗಳನ್ನು ರಚಿಸುವುದು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('trans.leavingCertificate') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('trans.leavingCertificate')">
        ಲೀವಿಂಗ್ ಸರ್ಟಿಫಿಕೇಟ್
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('trans.getStudentId') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('trans.getStudentId')">
        ವಿದ್ಯಾರ್ಥಿ ID ಪಡೆಯಿರಿ
    </x-dropdown-link>
</x-drop>

<x-drop :name="'ಶುಲ್ಕದ ವಿವರಗಳು'" :active="request()->routeIs('fees.*')">
    <x-dropdown-link href="{{ route('fees.feesReceipts') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('fees.feesReceipts')">
        ಶುಲ್ಕ ರಶೀದಿಗಳು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.receiptCancellation') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('fees.receiptCancellation')">
        ರಸೀದಿಗಳ ರದ್ದತಿ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.feesArrears') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('fees.feesArrears')">
        ಶುಲ್ಕ ಬಾಕಿ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.dayBook') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('fees.dayBook')">
        ದಿನದ ಪುಸ್ತಕ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.feesRegister') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('fees.feesRegister')">
        ಶುಲ್ಕ ನೋಂದಣಿ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.receiptDatewise') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('fees.receiptDatewise')">
        ರಶೀದಿ ದಿನಾಂಕವಾರು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('fees.duplicateReceipt') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('fees.duplicateReceipt')">
        ನಕಲಿ ರಸೀದಿ
    </x-dropdown-link>
</x-drop>

<x-drop :name="'ವರದಿಗಳು'" :active="request()->routeIs('report.*')">

    <x-dropdown-link href="{{ route('report.castDetails') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('report.castDetails')">
        ಪಾತ್ರವರ್ಗದ ವಿವರಗಳು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('report.feesStructure') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('report.feesStructure')">
        ಶುಲ್ಕ ರಚನೆ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('report.generalRegister') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('report.generalRegister')">
        ಸಾಮಾನ್ಯ ನೋಂದಣಿ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('report.classDetails') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('report.classDetails')">
        ವರ್ಗ ವಿವರಗಳು
    </x-dropdown-link>
</x-drop>

<x-drop :name="'ಪ್ರಮಾಣಪತ್ರಗಳು'" :active="request()->routeIs('certificate.*')">

    <x-dropdown-link href="{{ route('certificate.certificate') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('certificate.certificate')">
        ಪ್ರಮಾಣಪತ್ರಗಳು
    </x-dropdown-link>

</x-drop>

{{-- <x-drop :name="'Building Fund'" :active="request()->routeIs('building.*')">

    <x-dropdown-link href="{{route('building.receipt')}}" class="border-b border-b-indigo-200" :active="request()->routeIs('building.receipt')">
       Building Fund Receipt
    </x-dropdown-link>

    <x-dropdown-link href="{{route('building.duplicateReceipt')}}" class="border-b border-b-indigo-200" :active="request()->routeIs('building.duplicateReceipt')">
       Building Duplicate Receipt
    </x-dropdown-link>

    <x-dropdown-link href="{{route('building.dailyReport')}}" class="border-b border-b-indigo-200" :active="request()->routeIs('building.dailyReport')">
       Daily Report
    </x-dropdown-link>

    <x-dropdown-link href="{{route('building.report')}}" class="border-b border-b-indigo-200" :active="request()->routeIs('building.report')">
       Building Fund Report
    </x-dropdown-link>

    <x-dropdown-link href="{{route('building.receiptDeletion')}}" class="border-b border-b-indigo-200" :active="request()->routeIs('building.receiptDeletion')">
       Building Fund Receipt Deletion
    </x-dropdown-link>
    
</x-drop> --}}

<x-drop :name="'ಸಾಮಾನ್ಯ ರಸೀದಿಗಳು'" :active="request()->routeIs('general.*')">

    <x-dropdown-link href="{{ route('general.generalReceipts') }}" class="border-b border-b-indigo-200"
        :active="request()->routeIs('general.generalReceipts')">
        ಸಾಮಾನ್ಯ ರಸೀದಿಗಳು
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('general.dayBook') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('general.dayBook')">
        ದಿನದ ಪುಸ್ತಕ
    </x-dropdown-link>

    <x-dropdown-link href="{{ route('general.datewise') }}" class="border-b border-b-indigo-200" :active="request()->routeIs('general.datewise')">
        ದಿನಾಂಕವಾರು
    </x-dropdown-link>

</x-drop>
