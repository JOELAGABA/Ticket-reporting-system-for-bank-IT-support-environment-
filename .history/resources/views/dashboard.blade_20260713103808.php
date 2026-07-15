<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pride Bank - Internal IT Support Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-100/80 font-sans antialiased min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="bg-emerald-800 border-b-4 border-amber-500 text-white px-6 py-3 shadow-md flex justify-between items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold tracking-wider">PRIDE BANK</span>
                    <span class="ml-3 px-2 py-1 text-xs bg-amber-500 text-blue-950 font-semibold rounded">Internal ITSM Portal</span>
                </div>
                <div class="text-sm font-medium">
                    Logged in as: <span class="underline text-amber-400">Joel Muhanguzi (IT Support)</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Layout -->
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Centralized Incident Management Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">Monitoring live branch infrastructure, peripheral health, and core banking uptime status.</p>
        </div>

        <!-- System Success Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Real-Time Infrastructure Health Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Tickets -->
    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Incidents</span>
        <span class="text-2xl font-bold text-gray-800 mt-2">{{ $metrics['total'] }}</span>
    </div>

    <!-- Open Tickets -->
    <div class="bg-white p-4 rounded-xl border border-l-4 border-l-blue-500 border-gray-100 shadow-sm flex flex-col justify-between">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Open (Unassigned)</span>
        <span class="text-2xl font-bold text-blue-600 mt-2">{{ $metrics['open'] }}</span>
    </div>

    <!-- In Progress Tickets -->
    <div class="bg-white p-4 rounded-xl border border-l-4 border-l-amber-500 border-gray-100 shadow-sm flex flex-col justify-between">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active Investigations</span>
        <span class="text-2xl font-bold text-amber-600 mt-2">{{ $metrics['in_progress'] }}</span>
    </div>

    <!-- Resolved Tickets -->
    <div class="bg-white p-4 rounded-xl border border-l-4 border-l-green-500 border-gray-100 shadow-sm flex flex-col justify-between">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mitigated Outages</span>
        <span class="text-2xl font-bold text-green-600 mt-2">{{ $metrics['resolved'] }}</span>
    </div>
</div>

        <!-- Grid Layout for Form & Live Monitor -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Side: Incident Reporting Form Card -->
            <div class="bg-white shadow-md rounded-lg border border-gray-200 p-6 h-fit">
                <h2 class="text-lg font-bold text-gray-800 mb-1 border-b border-gray-100 pb-3">Log New Branch Incident</h2>
                <p class="text-xs text-gray-500 mb-4">Simulating a Teller logging a technical issue from a branch location.</p>

                <form action="{{ route('tickets.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Incident Summary / Title</label>
                        <input type="text" name="title" placeholder="e.g., Receipt Printer offline" required
                            class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Branch Location</label>
                        <select name="branch_location" required class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="Kampala Main Branch">Kampala Main Branch</option>
                            <option value="Jinja Branch">Jinja Branch</option>
                            <option value="Entebbe Branch">Entebbe Branch</option>
                            <option value="Mbarara Branch">Mbarara Branch</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Priority Urgency</label>
                        <select name="priority" required class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="Low">Low (General Query)</option>
                            <option value="Medium">Medium (Operational Flaw)</option>
                            <option value="High">High (Hardware Outage)</option>
                            <option value="Critical">Critical (Core System Down)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Detailed Log Description</label>
                        <textarea name="description" rows="3" placeholder="Provide full hardware error strings or clear symptoms..." required
                            class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-700 hover:text-white hover:bg-blue-800 font-semibold text-sm py-2.5 px-4 rounded transition-colors shadow shadow-blue-900/20">
                        Dispatch to IT Queue
                    </button>
                </form>
            </div>

            <!-- Right Side: Active Service Tickets Monitor Table -->
            <div class="lg:grid-cols-1 lg:col-span-2 bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Active Service Tickets Queue</h2>
                    <span class="px-2.5 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Live Monitor</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Incident ID</th>
                                <th class="px-6 py-3">Category & Details</th>
                                <th class="px-6 py-3">Branch</th>
                                <th class="px-6 py-3">Priority</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono text-gray-600 font-bold">
                                        #INC-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $ticket->title }}</div>
                                        <div class="text-gray-500 text-xs mt-0.5">{{ $ticket->description }}</div>
                                        <div class="text-xs text-gray-400 mt-1">Reported by: {{ $ticket->creator->name ?? 'System' }} ({{ $ticket->creator->role ?? 'User' }})</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 text-xs">
                                        {{ $ticket->branch_location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->priority === 'Critical')
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-red-100 text-red-800 animate-pulse border border-red-200">CRITICAL</span>
                                        @elseif($ticket->priority === 'High')
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-orange-100 text-orange-800">HIGH</span>
                                        @elseif($ticket->priority === 'Medium')
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-yellow-100 text-yellow-800">MEDIUM</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-green-100 text-green-800">LOW</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs font-semibold rounded-full px-2.5 py-1 focus:outline-none border border-transparent cursor-pointer
                                                @if($ticket->status === 'Open') bg-blue-100 text-blue-700 border-blue-200
                                                @elseif($ticket->status === 'In Progress') bg-amber-100 text-amber-700 border-amber-200
                                                @else bg-green-100 text-green-700 border-green-200 @endif">
                                                <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                                                <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Resolved" {{ $ticket->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
</select>
</form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No active technical incidents reported across network branches.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
