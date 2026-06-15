<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-800 leading-tight tracking-wide">
            {{ __('Top Up Wallet') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header & Balance -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-amber-900 tracking-tight">Top Up Wallet</h2>
                <p class="text-amber-700/80 mt-1 font-medium">Add funds to your PataShop account securely.</p>
            </div>
            
            <div class="bg-gradient-to-br from-amber-600 to-amber-500 rounded-3xl p-6 text-white shadow-lg min-w-[300px] relative overflow-hidden">
                <div class="absolute right-0 top-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                <p class="text-amber-100 font-bold mb-1 text-sm uppercase tracking-wider">Current Balance</p>
                <h3 class="text-4xl font-black">Rp {{ number_format(Auth::user()->money, 0, ',', '.') }}</h3>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-start">
                <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start">
                <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="font-bold mb-1">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Request Form -->
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                    <h3 class="text-xl font-black text-amber-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        New Request
                    </h3>
                    
                    <form action="{{ route('topups.store') }}" method="POST" x-data="topUpForm()">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-amber-900 mb-2">Amount to Top Up (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-amber-500 font-bold">Rp</span>
                                </div>
                                <input type="hidden" name="amount" :value="rawAmount">
                                <input type="text" x-model="formattedAmount" @input="updateAmount" class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-amber-900 pl-12 p-4 font-black text-xl" required placeholder="50.000">
                            </div>
                            <p class="text-xs text-amber-600 mt-2">Minimum top up is Rp 10.000</p>
                        </div>
                        
                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-black py-4 rounded-xl shadow-md transition-colors">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- History Table -->
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                    <h3 class="text-xl font-black text-amber-900 mb-6 border-b border-amber-100 pb-4">Top Up History</h3>
                    
                    @if($topUps->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-amber-800 text-sm border-b-2 border-amber-100">
                                        <th class="pb-3 font-bold">Date</th>
                                        <th class="pb-3 font-bold">Amount</th>
                                        <th class="pb-3 font-bold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-amber-900">
                                    @foreach($topUps as $topup)
                                    <tr class="border-b border-amber-50 hover:bg-amber-50/50 transition-colors">
                                        <td class="py-4">{{ $topup->created_at->format('d M Y, H:i') }}</td>
                                        <td class="py-4 font-bold">Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                                        <td class="py-4">
                                            @if($topup->status === 'pending')
                                                <span class="bg-amber-100 text-amber-800 text-xs font-black px-3 py-1 rounded-full">PENDING</span>
                                            @elseif($topup->status === 'approved')
                                                <span class="bg-green-100 text-green-800 text-xs font-black px-3 py-1 rounded-full">APPROVED</span>
                                            @elseif($topup->status === 'rejected')
                                                <span class="bg-red-100 text-red-800 text-xs font-black px-3 py-1 rounded-full">REJECTED</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 text-amber-700/50 italic font-medium">
                            <svg class="mx-auto h-12 w-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            You don't have any top-up history yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function topUpForm() {
        return {
            rawAmount: '',
            formattedAmount: '',
            updateAmount(e) {
                let val = e.target.value.replace(/\D/g, '');
                this.rawAmount = val;
                if (val) {
                    this.formattedAmount = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                } else {
                    this.formattedAmount = '';
                }
            }
        }
    }
</script>
</x-app-layout>
