<x-app-layout>
    <div class="container py-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 mt-8">
            <h1 class="text-3xl font-bold text-white">Lista de Paquetes</h1>
            @can('create', \App\Models\Package::class)
                <a href="{{ route('packages.create') }}" 
                   class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg 
                          transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Paquete
                </a>
            @endcan
        </div>

        <!-- Packages Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-pink-400">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="w-16 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">#</th>
                            <th class="w-1/5 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Nombre del Paquete</th>
                            <th class="w-1/6 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Formato</th>
                            <th class="w-1/6 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Canciones</th>
                            <th class="w-1/6 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Precio</th>
                            @can('viewAny', \App\Models\Package::class)
                                <th class="w-1/5 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Usuario</th>
                            @endcan
                            <th class="w-1/6 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Creado</th>
                            <th class="w-24 px-6 py-3 text-left text-lg font-bold text-gray-100 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-pink-400">
                        @forelse ($packages as $package)
                            <tr class="hover:bg-pink-100/10">
                                <td class="px-6 py-4 whitespace-nowrap text-[11px] font-normal text-gray-500">
                                    {{ $packages->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-[11px] font-normal text-gray-900">{{ $package->package_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-[11px] font-normal leading-5 rounded-full 
                                               {{ $package->format === 'WAV' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $package->format }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                             style="width: {{ ($package->tracks->count() / $package->songs_limit) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-[11px] font-normal text-gray-500 mt-1">
                                        {{$package->tracks->count()}}/{{ $package->songs_limit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-[11px] font-normal text-gray-900">
                                        ${{ number_format($package->price, 2) }}
                                    </div>
                                </td>
                                @can('viewAny', \App\Models\Package::class)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[11px] font-normal text-gray-900">{{ $package->users[0]->name }}</div>
                                        <div class="text-[11px] font-normal text-gray-500">{{ $package->users[0]->email }}</div>
                                    </td>
                                @endcan
                                <td class="px-6 py-4 whitespace-nowrap text-[11px] font-normal text-gray-500">
                                    {{ $package->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('packages.show', $package->id) }}" 
                                           class="text-pink-600 hover:text-pink-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @can('update', $package)
                                            <a href="{{ route('packages.edit', $package->id) }}" 
                                               class="text-pink-600 hover:text-pink-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 text-center">
                                    No hay paquetes disponibles
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    </div>
</x-app-layout>
