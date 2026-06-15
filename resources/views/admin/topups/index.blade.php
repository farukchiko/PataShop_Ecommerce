@extends('layouts.main')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Top Up Management</h2>
            <p class="text-amber-700/80 mt-2 font-medium">Review and process user top-up requests.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-start mb-6">
            <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start mb-6">
            <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
        @if($topUps->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-amber-800 text-sm border-b-2 border-amber-100">
                            <th class="pb-4 font-bold">Request Date</th>
                            <th class="pb-4 font-bold">User</th>
                            <th class="pb-4 font-bold">Amount</th>
                            <th class="pb-4 font-bold">Status</th>
                            <th class="pb-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-amber-900">
                        @foreach($topUps as $topup)
                        <tr class="border-b border-amber-50 hover:bg-amber-50/50 transition-colors">
                            <td class="py-5">{{ $topup->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-5">
                                <span class="font-bold block">{{ $topup->user->name }}</span>
                                <span class="text-xs text-amber-600">{{ $topup->user->email }}</span>
                            </td>
                            <td class="py-5 font-black text-amber-700">Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                            <td class="py-5">
                                @if($topup->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-xs font-black px-3 py-1 rounded-full border border-amber-200">PENDING</span>
                                @elseif($topup->status === 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs font-black px-3 py-1 rounded-full border border-green-200">APPROVED</span>
                                @elseif($topup->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 text-xs font-black px-3 py-1 rounded-full border border-red-200">REJECTED</span>
                                @endif
                            </td>
                            <td class="py-5 text-right">
                                @if($topup->status === 'pending')
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('admin.topups.approve', $topup->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm transition-colors" onclick="return confirm('Approve this top-up and add money to user?')">
                                            Approve
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.topups.reject', $topup->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-bold px-4 py-2 rounded-lg transition-colors border border-red-200" onclick="return confirm('Are you sure you want to reject this request?')">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-xs text-gray-400 font-medium italic">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 text-amber-700/50 italic font-medium">
                <svg class="mx-auto h-16 w-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <p class="text-lg">No top-up requests found.</p>
            </div>
        @endif
    </div>
@endsection
