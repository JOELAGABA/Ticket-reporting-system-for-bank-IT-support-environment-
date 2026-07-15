<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pride Bank - Internal IT Support Portal</title>
    <!-- Tailwind CSS CDN for instant styling -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Top Navigation Bar -->
    <nav class="bg-blue-900 text-white shadow-md">
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

        <!-- Live Incident Tickets Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Active Service Tickets</h2>
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
                            <th class="px-6 py-3">Assigned To</th>
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
                                    <div class="text-gray-500 text-xs mt-0.5 line-clamp-1">{{ $ticket->description }}</div>
                                    <div class="text-xs text-gray-400 mt-1">Reported by: {{ $ticket->creator->name }} ({{ $ticket->creator->role }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $ticket->branch_location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->priority === 'Critical')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded bg-red-100 text-red-800 animate-pulse border border-red-300">CRITICAL</span>
                                    @elseif($ticket->priority === 'High')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded bg-orange-100 text-orange-800">HIGH</span>
                                    @elseif($ticket->priority === 'Medium')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">MEDIUM</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">LOW</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->status === 'Open')
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Open</span>
                                    @elseif($ticket->status === 'In Progress')
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">In Progress</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Resolved</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-medium">
                                    {{ $ticket->assignee ? $ticket->assignee->name : 'Unassigned' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    No active technical incidents reported across network branches.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
