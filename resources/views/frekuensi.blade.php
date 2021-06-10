<x-template-layout>
    <div class="bg-gray-800 pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">{{$tittle}}</h3>
        </div>
    </div>
    <div class="table w-full p-2">
        <table class="w-2/5 border">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-0 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            No
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Skor
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Frekuensi
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="py-5">
                <?php $no = 1; ?>
                @foreach($frekuensi as $skor)
                <tr class="bg-gray-100 text-center border-b text-base text-gray-600">
                    <td class="p-2 border-r">{{$no}}</td>
                    <td class="p-2 border-r">{{ $skor->skor }}</td>
                    <td class="p-2 border-r">{{ $skor->frekuensi }}</td>
                </tr>
                <?php $no++ ?>
                @endforeach
            </tbody>
        </table>
    </div>
</x-template-layout>